<?php

namespace App\Abstracts\Controllers;

use App\Http\Controllers\Controller;

abstract class AbstractAdminController extends Controller
{
    /**
     * Renvoie la page d'accueil de la zone admin
     */
    abstract public function index();
}
