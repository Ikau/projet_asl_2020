<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

use App\Abstracts\AbstractControllerCRUD;
use App\Modeles\Stage;
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
            return redirect('/');

            case 'validerForm':
                $this->validerForm($request);
                abort('404');
            return redirect('/');

            case 'validerModele':
                $etudiant = $this->validerModele($request->id);
                abort('404');
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
        abort('404');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort('404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        abort('404');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort('404');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort('404');
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
        abort('404');
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

        // Convention signee
        $conventionSignee = $request[Stage::COL_CONVENTION_SIGNEE];
        if($request->missing(Stage::COL_CONVENTION_SIGNEE)
        || null === $conventionSignee
        || ! is_bool($conventionSignee))
        {
            $request[Stage::COL_CONVENTION_SIGNEE] = FALSE;
        }

        // Moyen de recherche
        $moyenRecherche = $request[Stage::COL_MOYEN_RECHERCHE];
        if($request->missing(Stage::COL_MOYEN_RECHERCHE)
        || null === $moyenRecherche
        || ! is_string($moyenRecherche))
        {
            $request[Stage::COL_MOYEN_RECHERCHE] = Constantes::STRING_VIDE;
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
        abort('404');
    }

    /**
     * Fonction qui doit faire la logique de validation de l'id
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function validerModele($id)
    {
        abort('404');
    }

    
    /**
     * Renvoie l'output de la fonction Schema::getColumnListing(Modele::NOM_TABLE)
     * 
     * @return void
     */
    protected function getAttributsModele()
    {
        abort('404');
    }
    
}
