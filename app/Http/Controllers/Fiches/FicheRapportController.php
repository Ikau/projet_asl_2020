<?php

namespace App\Http\Controllers\Fiches;

use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Fiches\ModeleNotation;
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
        // Recuperation des donnees
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
            'titre'    => self::VAL_TITRE_EDIT,
            'campus'   => 'Bourges',
            'stage'    => $ficheRapport->stage,
            'sections' => $ficheRapport->modele->sections
        ]);
    }

    public function update(Request $request, int $id)
    {
        // TODO: Implement update() method.
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

        // Contenu
        $contenu = $request[FicheRapport::COL_CONTENU];
        if($request->missing(FicheRapport::COL_CONTENU)
        || null === $contenu
        || ! is_array($contenu))
        {
            $request[FicheRapport::COL_CONTENU] = [];
        }
    }

    protected function validerForm(Request $request)
    {
        $request->validate([
            FicheRapport::COL_MODELE_ID => ['required', 'exists:'.ModeleNotation::NOM_TABLE.',id'],
            FicheRapport::COL_STAGE_ID  => ['required', 'exists:'.Stage::NOM_TABLE.',id']
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
