<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Abstracts\Controllers\AbstractAdminController;

class AdminController extends AbstractAdminController
{
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
