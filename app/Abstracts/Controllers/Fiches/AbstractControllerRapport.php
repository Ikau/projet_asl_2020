<?php

namespace App\Abstracts\Controllers\Fiches;

use Illuminate\Http\Request;

use App\Http\Controllers\AbstractFichesController;

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
}
