<?php

namespace App\Http\Controllers\Admin;

use App\Abstracts\Controllers\AbstractAdminController;
use App\Http\Middleware\VerifieEstAdministrateur;

class AdminController extends AbstractAdminController
{
    /* ------------------------------------------------------------------
     *                       Valeurs du modele
     * ------------------------------------------------------------------
     */

    /**
     * Indique a Lavel que toutes les fonctions de callback demandent un utilisateur
     * authentifie
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(VerifieEstAdministrateur::class);
    }

    /**
     * Renvoie la page d'accueil de la zone administrateur.
     *
     * @return View Vue blade 'admin.index'
     */
    public function index()
    {
        return view('admin.index', [
            'titre' => 'Zone administrateur'
        ]);
    }
}
