<?php

namespace App\Http\Controllers\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

use App\User;
use App\Abstracts\AbstractControllerCRUD;
use App\Utils\Constantes;

class UserController extends AbstractControllerCRUD
{

    /**
     * Valeur attendue du tag <title> pour les pages
     */
    const TITRE_INDEX  = 'Gestion des utilisateurs';
    const TITRE_CREATE = 'ajouter un utilisateur';
    const TITRE_SHOW   = 'Details de l\'utilisateur';
    const TITRE_EDIT   = 'Editer un utilisateur';


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
                /* Il n'y a pas de champs optionnels pour l'instant
                if(...)
                {
                    abort('404');
                }
                */
            return redirect('/');

            case 'validerForm':
                $this->validerForm($request);
            return redirect('/');

            case 'validerModele':
                $user = $this->validerModele($request->id);
                if(null === $user)
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
        // Il n'y a pas de champs optionnels pour l'instant
    }

    /**
     * Fonction qui doit faire la logique de validation des inputs d'une requete entrante.
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    protected function validerForm(Request $request)
    {
        $request->validate([
            User::COL_EMAIL         => ['required', 'email'],
            User::COL_HASH_PASSWORD => ['required', 'string']
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

        return User::find($id);
    }

    
    /**
     * Renvoie l'output de la fonction Schema::getColumnListing(Modele::NOM_TABLE)
     * 
     * @return void
     */
    protected function getAttributsModele()
    {
        return Schema::getColumnListing(User::NOM_TABLE);
    }
}
