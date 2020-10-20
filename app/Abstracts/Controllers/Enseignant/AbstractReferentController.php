<?php

namespace App\Abstracts\Controllers\Enseignant;

use App\Http\Controllers\Controller;

abstract class AbstractReferentController extends Controller
{
    /**
     * Renvoie la page d'accueil de l'enseignant authentifie.
     */
    abstract public function index();

    /**
     * Renvoie la page contenant toutes les affectations de l'ensignant.
     */
    abstract public function affectations();
}
