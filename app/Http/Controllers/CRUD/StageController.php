<?php

namespace App\Http\Controllers\CRUD;

use App\Abstracts\Controllers\AbstractControllerCRUD;
use App\Facade\FicheFacade;
use App\Http\Controllers\Enseignant\ResponsableController;
use App\Modeles\Enseignant;
use App\Modeles\Etudiant;
use App\Modeles\Stage;
use App\Utils\Constantes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class StageController extends AbstractControllerCRUD
{

    /**
     * Valeur attendue du tag <title> pour les pages
     */
    const TITRE_INDEX  = 'Gestion des stages';
    const TITRE_CREATE = 'Creer un stage';
    const TITRE_SHOW   = 'Details du stage';
    const TITRE_EDIT   = 'Editer un stage';

    /**
     * Valeur attendue du tag <title> pour les pages
     */

    /* ====================================================================
     *                             RESOURCES
     * ====================================================================
     */

    /**
     * Route de tests pour les fonctions auxiliaires.
     *
     * @return \Illuminate\Http\Response
     */
    public function tests(Request $request)
    {
        switch($request->test)
        {
            case 'normaliseInputsOptionnels':
                $this->normaliseInputsOptionnels($request);
                if( ! is_bool($request[Stage::COL_CONVENTION_ENVOYEE])
                ||  ! is_bool($request[Stage::COL_CONVENTION_SIGNEE])
                ||  ! is_string($request[Stage::COL_MOYEN_RECHERCHE])
                ||  (null !== $request[Stage::COL_REFERENT_ID] && ! is_integer($request[Stage::COL_REFERENT_ID])) )
                {
                    abort('404');
                }
            return redirect('/');

            case 'validerForm':
                $this->validerForm($request);
            return redirect('/');

            case 'validerModele':
                $stage = $this->validerModele($request->id);
                if(null === $stage)
                {
                    abort('404');
                }
            return redirect('/');

            default:
                abort('404');
            break;
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $attributs = Schema::getColumnListing(Stage::NOM_TABLE);

        // Suppression de la colonne 'Resume'
        for($i=0; $i<count($attributs); $i++)
        {
            if(Stage::COL_RESUME === $attributs[$i])
            {
                unset($attributs[$i]);
            }
        }
        $stages = Stage::all();

        return view('admin.modeles.stage.index', [
            'titre'     => StageController::TITRE_INDEX,
            'attributs' => $attributs,
            'stages'    => $stages,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $enseignants = Enseignant::orderBy(Enseignant::COL_NOM, 'asc')->get();
        $etudiants   = Etudiant::orderBy(Etudiant::COL_NOM, 'asc')->get();

        // Si redirection depuis une zone de responsable
        $titre = StageController::TITRE_CREATE;
        if(null !== Auth::user()
        && (Auth::user()->estResponsableOption() || Auth::user()->estResponsableDepartement()))
        {
            $titre = ResponsableController::TITRE_GET_FORM_AFFECTATION;
        }

        return view('admin.modeles.stage.form', [
            'titre'       => $titre,
            'etudiants'   => $etudiants,
            'enseignants' => $enseignants
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Controle d'acces
        $user = Auth::user();
        if(null === $user)
        {
            abort('404');
        }

        $this->validerForm($request);

        // Creation du stage
        $stage = new Stage();
        $stage->fill($request->all());
        $stage->save();

        // Creation des fiches
        FicheFacade::creerFiches($stage->id);

        // Redirection selon l'utilisateur
        if($user->estAdministrateur())
        {
            return redirect()->route('stages.index')->with('success', 'Stage ajoute !');
        }
        return redirect()->route('referents.index')->with('success', 'Stage ajoute !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $stage = $this->validerModele($id);
        if(null === $stage)
        {
            abort('404');
        }

        return view('admin.modeles.stage.show', [
            'titre'    => StageController::TITRE_SHOW,
            'stage'    => $stage,
            'etudiant' => Etudiant::find($stage->etudiant_id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $stage = $this->validerModele($id);
        if(null === $stage)
        {
            abort('404');
        }

        $attributs   = Schema::getColumnListing(Stage::NOM_TABLE);
        $enseignants = Enseignant::all();
        $etudiants   = Etudiant::all();

        return view('admin.modeles.stage.form', [
            'titre'       => StageController::TITRE_EDIT,
            'stage'       => $stage,
            'attributs'   => $attributs,
            'etudiants'   => $etudiants,
            'enseignants' => $enseignants
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validerForm($request);
        $stage = $this->validerModele($id);
        if(null === $stage)
        {
            abort('404');
        }

        $stage->update($request->all());
        $stage->save();

        return redirect()->route('stages.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $stage = $this->validerModele($id);
        if(null === $stage)
        {
            abort('404');
        }
        $stage->delete();

        return redirect()->route('stages.index');
    }

    /* ====================================================================
     *                             AUXILIAIRES
     * ====================================================================
     */

    /**
     * Normalise les inputs utilisateur qui sont null
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function normaliseInputsOptionnels(Request $request)
    {
        // Convention envoyee
        $conventionEnvoyee = $request[Stage::COL_CONVENTION_ENVOYEE];
        if($request->missing(Stage::COL_CONVENTION_ENVOYEE)
        || null === $conventionEnvoyee
        || ! is_bool($conventionEnvoyee))
        {
            $request[Stage::COL_CONVENTION_ENVOYEE] = FALSE;
        }
        else if('on' === $request[Stage::COL_CONVENTION_ENVOYEE])
        {
            $request[Stage::COL_CONVENTION_ENVOYEE] = TRUE;
        }

        // Convention signee
        $conventionSignee = $request[Stage::COL_CONVENTION_SIGNEE];
        if($request->missing(Stage::COL_CONVENTION_SIGNEE)
        || null === $conventionSignee
        || ! is_bool($conventionSignee))
        {
            $request[Stage::COL_CONVENTION_SIGNEE] = FALSE;
        }
        else if('on' === $request[Stage::COL_CONVENTION_SIGNEE])
        {
            $request[Stage::COL_CONVENTION_SIGNEE] = TRUE;
        }

        // Moyen de recherche
        $moyenRecherche = $request[Stage::COL_MOYEN_RECHERCHE];
        if($request->missing(Stage::COL_MOYEN_RECHERCHE)
        || null === $moyenRecherche
        || ! is_string($moyenRecherche))
        {
            $request[Stage::COL_MOYEN_RECHERCHE] = Constantes::STRING_VIDE;
        }

        // Referent
        $idReferent = $request[Stage::COL_REFERENT_ID];
        if($request->missing(Stage::COL_REFERENT_ID)
        || ! is_numeric($idReferent))
        {
            $request[Stage::COL_REFERENT_ID] = null;
        }
    }

    /**
     * Fonction qui doit faire la logique de validation des inputs d'une requete entrante.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function validerForm(Request $request)
    {
        $validation = $request->validate([
            Stage::COL_ANNEE          => ['required', Rule::in([4, 5])],
            Stage::COL_DATE_DEBUT     => ['required', 'date', 'before:'.Stage::COL_DATE_FIN],
            Stage::COL_DATE_FIN       => ['required', 'date', 'after:'.Stage::COL_DATE_DEBUT],
            Stage::COL_DUREE_SEMAINES => ['required', 'integer', 'between:10,40'],
            Stage::COL_GRATIFICATION  => ['required', 'numeric'],
            Stage::COL_INTITULE       => ['required', 'string'],
            Stage::COL_LIEU           => ['required', 'string'],
            Stage::COL_RESUME         => ['required', 'string'],
            Stage::COL_ETUDIANT_ID    => ['required', 'integer', 'min:0'],

            // Ce n'est pas elegant mais je n'ai pas trouve mieux pour les boolean
            Stage::COL_CONVENTION_ENVOYEE => ['sometimes', 'nullable', Rule::in(['on', FALSE, TRUE, 0, 1])],
            Stage::COL_CONVENTION_SIGNEE  => ['sometimes', 'nullable', Rule::in(['on', FALSE, TRUE, 0, 1])],
            Stage::COL_MOYEN_RECHERCHE    => ['sometimes', 'nullable', 'string'],
            Stage::COL_REFERENT_ID        => ['sometimes', 'nullable', 'exists:'.Enseignant::NOM_TABLE.',id'],
        ]);

        $this->normaliseInputsOptionnels($request);
    }

    /**
     * Fonction qui doit faire la logique de validation de l'id
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function validerModele($id)
    {
        if(null === $id
        || ! is_numeric($id))
        {
            return null;
        }

        return Stage::find($id);
    }
}
