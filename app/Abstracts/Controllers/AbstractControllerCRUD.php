<?php

namespace App\Abstracts\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * Classe abstraite pour la plupart des controleurs de l'application.
 *
 * La classe est majoritairement utilisée par les controleurs CRUD
 * (Create, Read, Update, Delete) : typiquement pour la page admin des modeles.
 *
 * Pour des classes plus complexes, il serait recommandé de creer une toute nouvelle abstraction.
 * Les classes filles qui decoule de celle courante ne font que le stricte minimum.
 *
 * @package App\Abstracts\Controllers
 */
abstract class AbstractControllerCRUD extends Controller
{
    /* ====================================================================
     *                             RESOURCES
     * ====================================================================
     */

    /**
     * Liste les donnees presentes dans la table du modele.
     *
     * @return \Illuminate\Http\Response
     */
    abstract public function index();

    /**
     * Affiche le formulaire pour creer une nouvelle entre dans la table du modele.
     *
     * @return \Illuminate\Http\Response
     */
    abstract public function create();

    /**
     * Sauvegarde une nouvelle entree dans la table du modele.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    abstract public function store(Request $request);

    /**
     * Affiche l'entree $id dans la table du modele.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    abstract public function show($id);

    /**
     * Affiche le formulaire d'edition de l'entree $id dans ma table du modele.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    abstract public function edit($id);

    /**
     * Met a jour l'entree $id dans la table du modele.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    abstract public function update(Request $request, $id);

    /**
     * Supprime l'entree $id de la table du modele.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    abstract public function destroy($id);

    /**
     * Callback pour tous les tests (notammant PHPUnit) necessaire du controller
     *
     * Ce n'est pas elegant mais je n'ai pas trouve de meilleures facons
     *
     * @param  mixed $request
     * @return void
     */
    abstract public function tests(Request $request);


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
    abstract protected function normaliseInputsOptionnels(Request $request);

    /**
     * Fonction qui doit faire la logique de validation des inputs d'une requete entrante.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    abstract protected function validerForm(Request $request);

    /**
     * Fonction qui doit faire la logique de validation de l'id
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    abstract protected function validerModele($id);
}
