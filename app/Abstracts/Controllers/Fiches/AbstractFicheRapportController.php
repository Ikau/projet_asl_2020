<?php

namespace App\Abstracts\Controllers\Fiches;

use Illuminate\Http\Request;

abstract class AbstractFicheRapportController extends AbstractFichesController
{

    /* ====================================================================
     *                             RESOURCES
     * Les fonctions listees ici sont a implementer pour le controller
     * en suivant les conventions de nommage Laravel
     * ====================================================================
     */
    abstract public function tests(Request $request);
    abstract public function show(int $idStage);
    abstract public function edit(int $idStage);
    abstract public function update(Request $request, int $idStage);


    /* ====================================================================
     *                             AUXILIAIRES
     * Les fonctions auxiliaires devraient etre implementees pour faciliter
     * la maintenance du controller
     * Voir les exemples d'implementation via les implementation de CRUD
     * ====================================================================
     */
    abstract protected function normaliseInputsOptionnels(Request $request);
    abstract protected function validerForm(Request $request);
    abstract protected function validerModele(int $idStage);
    abstract protected function getAttributsModele();
}
