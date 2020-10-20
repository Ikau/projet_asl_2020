<?php

namespace App\Abstracts\Controllers\Enseignant;

use App\Http\Controllers\Controller;

abstract class AbstractResponsableController extends Controller
{
    /**
     * Renvoie la page avec le formulaire de creation d'une affectation
     */
    abstract public function getCreateAffectation();

    /**
     * Renvoie la page listant toutes les affectations que le responsable peut modifier
     */
    abstract public function getIndexAffectation();

    /**
     * Valide une affectation si les conditions sont correctes
     */
    abstract public function postValiderAffectation(int $idStage);
}
