<?php

namespace App\Abstracts\Controllers\Fiches;

use Illuminate\Http\Request;

use App\Abstracts\Controllers\Fiches\AbstractFichesController;

abstract class AbstractFicheRapportController extends AbstractFichesController
{

    /* ====================================================================
     *                             RESOURCES
     * Les fonctions listees ici sont a implementer pour le controller
     * en suivant les convention de nommage Laravel
     * ====================================================================
     */
    abstract public function show($idProjet, $id);
    abstract public function store($idProjet, $id);
    abstract public function edit($idProjet, $id);
    abstract public function update($idProjet, $id);
    abstract public function tests($request);


    /* ====================================================================
     *                             AUXILIAIRES
     * Les fonctions auxiliaires devraient etre implementees pour faciliter
     * la maintenance du controller
     * Voir les exemples d'implementation via les implementation de CRUD
     * ====================================================================
     */
    abstract protected function normaliseInputsOptionnels(Request $request);
    abstract protected function validerForm(Request $request);
    abstract protected function validerModele($id);
    abstract protected function getAttributsModele();
}
