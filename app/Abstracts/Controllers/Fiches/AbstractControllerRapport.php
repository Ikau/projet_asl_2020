<?php

namespace App\Abstracts\Controllers\Fiches;

use App\User;
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
    abstract public function show(int $idStage);
    abstract public function store($idStage);
    abstract public function edit($idStage);
    abstract public function update($idStage);
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
    abstract protected function getAttributsModele();
}
