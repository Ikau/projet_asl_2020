<?php

namespace App\Abstracts\Controllers\Scolarite;

use App\Http\Controllers\Controller;

abstract class AbstractScolariteController extends Controller
{
    /**
     * Renvoie la page d'accueil de la scolarite.
     */
    abstract public function index();

    /**
     * Renvoie la page contenant les affectations de tous les enseignants
     */
    abstract public function affectations();
}
