<?php

namespace App\Http\Controllers\Scolarite;

use App\Abstracts\Controllers\Scolarite\AbstractScolariteController;
use App\Http\Middleware\VerifieEstScolarite;
use App\Utils\Constantes;
use Illuminate\Support\Facades\Gate;

class ScolariteController extends AbstractScolariteController
{
    /* ------------------------------------------------------------------
     *                       Valeurs du modele
     * ------------------------------------------------------------------
     */
    /*
     * Valeur des differents titres des pages du controller
     */
    const VAL_TITRE_INDEX = 'Scolarite - Accueil';

    /**
     * Indique a Lavel que toutes les fonctions de callback demandent un utilisateur
     * authentifie
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(VerifieEstScolarite::class);
    }

    /* ------------------------------------------------------------------
     *                        Overrides abstract
     * ------------------------------------------------------------------
     */
    /**
     * Renvoie la page d'accueil de la scolarite.
     */
    public function index()
    {
        return view('scolarite.index', [
            'titre' => self::VAL_TITRE_INDEX
        ]);
    }

    /**
     * Renvoie la page contenant les affectations de tous les enseignants
     */
    public function affectations()
    {
    }
}
