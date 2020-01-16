<?php 

namespace App\Abstracts\Controllers\Enseignant;

use Illuminate\Http\Request; 

use App\Http\Controllers\Controller;

abstract class AbstractControllerCRUD extends Controller
{
    /**
     * Renvoie la page d'accueil de l'enseignant authentifie.
     */
    abstract public function index();
}