<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

use App\Abstracts\AbstractControllerCRUD;
use App\Modeles\Stage;
use App\Modeles\Enseignant;
use App\Modeles\Etudiant;
use App\Utils\Constantes;

class StageController extends AbstractControllerCRUD
{

    /**
     * Valeur attendue du tag <title> pour les pages
     */
    const TITRE_INDEX  = 'Gestion des stages';
    const TITRE_CREATE = 'Creer un stage';
    const TITRE_SHOW   = 'Details du stage';
    const TITRE_EDIT   = 'Editer un stage';


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
                if( ! is_bool($request[Stage::COL_CONVENTION_ENVOYEE]) )
                {
                    abort('404');
                }
                if( ! is_bool($request[Stage::COL_CONVENTION_SIGNEE]) )
                {
                    abort('404');
                }
                if( ! is_string($request[Stage::COL_MOYEN_RECHERCHE]) )
                {
                    abort('404');
                }
                if( ! is_integer($request[Stage::COL_REFERENT_ID]) )
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
        $attributs = $this->getAttributsModele();

        // Suppression de la colonne 'Resume'
        for($i=0; $i<count($attributs); $i++)
        {
            if(Stage::COL_RESUME === $attributs[$i])
            {
                unset($attributs[$i]);
            }
        }
        $stages = Stage::all();

        return view('stage.index', [
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
        $attributs   = $this->getAttributsModele();
        $enseignants = Enseignant::all();
        $etudiants   = Etudiant::all();

        // WIP : pour avoir des dates correctes pour tester le form
        $stageTemp = factory(Stage::class)->make();

        return view('stage.form', [
            'titre'       => StageController::TITRE_CREATE,
            'etudiants'   => $etudiants,
            'enseignants' => $enseignants,
            'wip_debut'   => $stageTemp->date_debut,
            'wip_fin'     => $stageTemp->date_fin,
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
        $this->validerForm($request);

        $stage = new Stage();
        $stage->fill($request->all());
        $stage->save();

        return redirect()->route('stages.index');
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

        return view('stage.show', [
            'titre' => StageController::TITRE_SHOW,
            'stage' => $stage
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

        $attributs   = $this->getAttributsModele();
        $enseignants = Enseignant::all();
        $etudiants   = Etudiant::all();
        
        return view('stage.form', [
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
        abort('404');
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
        $referent = Enseignant::find($request[Stage::COL_REFERENT_ID]);
        if($request->missing(Stage::COL_REFERENT_ID)
        || null === $referent)
        {
            $request[Stage::COL_REFERENT_ID] = Enseignant::getModeleDefaut()->id;
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
            Stage::COL_REFERENT_ID        => ['sometimes', 'nullable', 'integer', 'min:0'],
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

    
    /**
     * Renvoie l'output de la fonction Schema::getColumnListing(Modele::NOM_TABLE)
     * 
     * @return void
     */
    protected function getAttributsModele()
    {
        return Schema::getColumnListing(Stage::NOM_TABLE);
    }
    
}
