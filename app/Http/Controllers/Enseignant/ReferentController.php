<?php

namespace App\Http\Controllers\Enseignant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Abstracts\Controllers\Enseignant\AbstractReferentController;
use App\Utils\Constantes;

class ReferentController extends AbstractReferentController
{

    /**
     * Valeur attendue du tag <title> pour les pages
     */
    const TITRE_INDEX  = 'Enseignant - Tableau de bord';
    const TITRE_CREATE = 'ajouter un TEMPLATE';
    const TITRE_SHOW   = 'Details du TEMPLATE';
    const TITRE_EDIT   = 'Editer un TEMPLATE';

    /**
     * Nom des differents gates pour le controller 'Referent'
     * Pour rappel : les gates sont enregistres dans App\Provider\AuthServiceProvider
     */
    const GATE_GET_ACCUEIL = 'get-accueil-enseignant';

    /**
     * Indique a Lavel que toutes les fonctions de callback demandent un utilisateur
     * authentifie
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* ====================================================================
     *                             RESOURCES
     * ====================================================================
     */

    /**
     * Renvoie la page d'accueil de l'enseignant authentifie.
     */
    public function index() 
    {
        Gate::authorize(ReferentController::GATE_GET_ACCUEIL);

        return view('enseignant.commun.index', [
            'titre' => ReferentController::TITRE_INDEX,
            'user'  => Auth::user()
        ]);
    }

}
