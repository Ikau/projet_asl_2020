<?php

namespace App\Http\Controllers\Admin;

use App\Abstracts\Controllers\AbstractAdminController;
use App\Utils\Constantes;
use Illuminate\Support\Facades\Gate;

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
    }

    /**
     * Renvoie la page d'accueil de la zone administrateur.
     *
     * @return View Vue blade 'admin.index'
     */
    public function index()
    {
        Gate::authorize(Constantes::GATE_ROLE_ADMINISTRATEUR);

        return view('admin.index', [
            'titre' => 'Zone administrateur'
        ]);
    }
}
