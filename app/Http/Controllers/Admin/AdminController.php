<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

class AdminController extends Controller
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
