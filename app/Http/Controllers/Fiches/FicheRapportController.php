<?php

namespace App\Http\Controllers\Fiches;

use App\Facade\FicheFacade;
use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Fiches\ModeleNotation;
use App\Modeles\Fiches\Section;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use App\Abstracts\Controllers\Fiches\AbstractFicheRapportController;

use App\Modeles\Enseignant;
use App\Modeles\Etudiant;
use App\Modeles\Stage;

use App\Utils\Constantes;

class FicheRapportController extends AbstractFicheRapportController
{

    /* ====================================================================
     *                         VALEURS DU MODELE
     * ====================================================================
     */
    /*
     * Valeurs attendues du tag <titles> pour les pages
     */
    const VAL_TITRE_SHOW = 'Enseignant - Rapport';
    const VAL_TITRE_EDIT = 'Enseignant - Rapport';

    /**
     * Indique a Lavel que toutes les fonctions de callback demandent un utilisateur
     * authentifie
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'tests']);
    }


    /* ====================================================================
     *                             RESOURCES
     * ====================================================================
     */
    public function tests(Request $request)
    {
        switch($request->test)
        {
            case 'normaliseInputsOptionnels':
                $this->normaliseInputsOptionnels($request);
                if( ! is_string($request[FicheRapport::COL_APPRECIATION]) )
                {
                    abort('404');
                }
                if( ! is_array($request[FicheRapport::COL_CONTENU]) )
                {
                    abort('404');
                }
                return redirect('/');

            case 'validerForm':
                $this->validerForm($request);
                return redirect('/');

            case 'validerModele':
                $fiche = $this->validerModele($request->id);
                if(null === $fiche)
                {
                    abort('404');
                }
                return redirect('/');

            default:
                abort('404');
                break;
        }
    }

    public function show(int $id)
    {
        // Verification du modele
        $ficheRapport = $this->validerModele($id);
        if(null === $ficheRapport)
        {
            abort('404');
        }

        // Autorisation
        $this->verifieAcces(Auth::user(), $ficheRapport);

        return view('fiches.rapport.show', [
            'titre' => self::VAL_TITRE_SHOW,
            'fiche' => $ficheRapport,
            'stage' => $ficheRapport->stage
        ]);
    }

    public function edit(int $id)
    {
        // Recuperation des donnees
        $ficheRapport = $this->validerModele($id);
        if(null === $ficheRapport)
        {
            abort('404');
        }

        // Autorisation
        $this->verifieAcces(Auth::user(), $ficheRapport);

        return view('fiches.rapport.form', [
            'titre'       => self::VAL_TITRE_EDIT,
            'campus'      => 'Bourges',
            'stage'       => $ficheRapport->stage,
            'sections'    => $ficheRapport->modele->sections
        ]);
    }

    public function update(Request $request, int $id)
    {
        // Verificaiton du modele
        $ficheRapport = $this->validerModele($id);
        if(null === $ficheRapport)
        {
            abort('404');
        }

        // Autorisation
        $this->verifieAcces(Auth::user(), $ficheRapport);

        // Validation du form
        $this->validerForm($request);

        // Mise a jour des choix si besoin
        $nouveauContenu = $ficheRapport->contenu;
        $sections       = $ficheRapport->modele->sections;
        if($request->has(FicheRapport::COL_CONTENU))
        {
            $inputs = $request[FicheRapport::COL_CONTENU];
            for($i=0; $i<count($sections); $i++)
            {
                // Si l'index n'existe pas on saute
                if( ! array_key_exists($i, $inputs))
                {
                    continue;
                }

                // On va mettre a jour les choix
                $section = $sections[$i];
                for($j=0; $j<count($section->criteres); $j++)
                {
                    // On met a jour seulement si c'est une valeur correcte
                    $choixCourant = (int)($inputs[$i][$j]);
                    if(0 <= $choixCourant && $choixCourant < count($section->choix))
                    {
                        $nouveauContenu[$i][$j] = $choixCourant;
                    }
                }
            }
        }

        // Mise a jour des elements restants
        $ficheRapport->fill([
            FicheRapport::COL_CONTENU      => $nouveauContenu,
            FicheRapport::COL_APPRECIATION => $request[FicheRapport::COL_APPRECIATION]
        ]);
        $ficheRapport->statut = $ficheRapport->getStatut();
        $ficheRapport->save();

        return redirect()->route('fiches.rapport.show', $ficheRapport->id);
    }

    /* ====================================================================
     *                     FONCTION AUXILIAIRES
     * ====================================================================
     */
    protected function normaliseInputsOptionnels(Request $request)
    {
        // Appreciation
        $appreciation = $request[FicheRapport::COL_APPRECIATION];
        if($request->missing(FicheRapport::COL_APPRECIATION)
        || null === $appreciation
        || ! is_string($appreciation))
        {
            $request[FicheRapport::COL_APPRECIATION] = "";
        }

        // Contenu manquant
        $contenu = $request[FicheRapport::COL_CONTENU];
        if($request->missing(FicheRapport::COL_CONTENU)
        || null === $contenu
        || ! is_array($contenu))
        {
            $modele = ModeleNotation::find($request->modele_id);
            $request[FicheRapport::COL_CONTENU] = FicheFacade::creerContenuVide($modele);
        }
        else // Normalisation du contenu
        {
            $modele         = ModeleNotation::find($request->modele_id);
            $sections       = $modele->sections()->orderBy(Section::COL_ORDRE, 'asc')->get();
            $arrayNormalise = [];

            for($i=0; $i<count($sections); $i++)
            {
                $sectionVide = array_fill(0, count($sections[$i]->criteres), -1);
                if( ! array_key_exists($i, $contenu) )
                {
                    $arrayNormalise[] = $sectionVide;
                    continue;
                }

                for($j=0; $j<count($contenu[$i]); $j++)
                {
                    $nbChoix = count($sections[$i]->choix);
                    if($j > $nbChoix)
                    {
                        continue;
                    }

                    $choixCourant = (int)($contenu[$i][$j]);
                    if(0 <= $choixCourant && $choixCourant < $nbChoix)
                    {
                        $sectionVide[$j] = $choixCourant;
                    }
                }
                $arrayNormalise[] = $sectionVide;
            }
            $request[FicheRapport::COL_CONTENU] = $arrayNormalise;
        }
    }

    protected function validerForm(Request $request)
    {
        $request->validate([
            FicheRapport::COL_MODELE_ID => ['required', 'exists:'.ModeleNotation::NOM_TABLE.',id']
        ]);

        $this->normaliseInputsOptionnels($request);
    }

    protected function validerModele($id)
    {
        if(null === $id
            || ! is_numeric($id))
        {
            return null;
        }

        return FicheRapport::find($id);
    }

    protected function getAttributsModele()
    {
        // TODO: Implement getAttributsModele() method.
    }

    /* ====================================================================
     *                     FONCTION PRIVEES
     * ====================================================================
     */
    private function verifieAcces(User $user, FicheRapport $ficheRapport)
    {
        Gate::authorize(Constantes::GATE_ROLE_ENSEIGNANT);

        if( $user->cant('show', $ficheRapport) )
        {
            abort('404');
        }
    }
}
