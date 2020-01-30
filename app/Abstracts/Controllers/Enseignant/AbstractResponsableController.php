<?php 

namespace App\Abstracts\Controllers\Enseignant;

use App\Http\Controllers\Controller;

abstract class AbstractResponsableController extends Controller
{
    /**
     * Renvoie la page avec le formulaire de creation d'une affectation
     */
    abstract public function getFormAffectation();
}