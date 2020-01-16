<?php

namespace App\Http\Controllers\Enseignant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Abstracts\Controllers\AbstractReferentController;
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


    /* ====================================================================
     *                             RESOURCES
     * ====================================================================
     */

    /**
     * Renvoie la page d'accueil de l'enseignant authentifie.
     */
    public function index() 
    {
        $user = Auth::user();

        if(null === $user)
        {
            abort('404');
        }

        return view('enseignant.commun.index', [
            'titre' => ReferentController::TITRE_INDEX,
            'user'  => Auth::user()
        ]);
    }

}
