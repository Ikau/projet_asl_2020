<?php

namespace App\Http\Controllers\CRUD;

use Illuminate\Http\Request;


use App\Abstracts\AbstractControllerCRUD;
use App\Modeles\Enseignant;
use App\Utils\Constantes;

class EnseignantController extends AbstractControllerCRUD
{

    /**
     * Valeur attendue du tag <title> pour les pages
     */
    const TITRE_INDEX  = 'Gestion des enseignants';
    const TITRE_CREATE = 'Creer un enseignant';
    const TITRE_SHOW   = 'Details du enseignant';
    const TITRE_EDIT   = 'Editer un enseignant';

    public function index()
    {
        $enseignants = Enseignant::all();

        return view('enseignant.index', [
            'titre'      => EnseignantController::TITRE_INDEX,
            'enseignants' => $enseignants,
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function tests(Request $request)
    {
        return;
    }

    /**
     * Fonction qui remplace les valeurs optionnels null par des valeurs par defaut
     */
    protected function normaliseInputsOptionnels(Request $request)
    {
        return;
    }

    /**
     * Fonction qui se charge de valider tous les inputs issus d'un POST, PATCH, PUT
     */
    protected function validerForm(Request $request)
    {
        return;
    }

    /**
     * Fonction qui valide la validite de l'id donnee et renvoie un enseignant le cas echeant
     */
    protected function validerModele($id)
    {
        return;
    }

}
