<?php

namespace App\Http\Controllers\Enseignant;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use App\Abstracts\Controllers\Enseignant\AbstractReferentController;

use App\Modeles\Enseignant;
use App\Modeles\Etudiant;
use App\Modeles\Stage;

use App\Utils\Constantes;

class ReferentController extends AbstractReferentController
{
    /* ====================================================================
     *                         VALEURS DU MODELE
     * ====================================================================
     */

    /*
     * Valeur attendue du tag <title> pour les pages
     */
    const TITRE_INDEX        = 'Enseignant - Tableau de bord';
    const TITRE_AFFECTATIONS = 'Enseignant - Mes affectations';
    const TITRE_CREATE       = 'ajouter un TEMPLATE';
    const TITRE_SHOW         = 'Details du TEMPLATE';
    const TITRE_EDIT         = 'Editer un TEMPLATE';

    /**
     * Nom des differents gates pour le controller 'Referent'
     * Pour rappel : les gates sont enregistres dans App\Provider\AuthServiceProvider
     */
    const GATE_ROLE_ENSEIGNANT = 'role-enseignant';

    /**
     * Indique a Lavel que toutes les fonctions de callback demandent un utilisateur
     * authentifie
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /* ====================================================================
     *                      IMPLEMENTATION ABSTRACT
     * ====================================================================
     */

    /**
     * Renvoie la page d'accueil de l'enseignant authentifie.
     */
    public function index() 
    {
        Gate::authorize(ReferentController::GATE_ROLE_ENSEIGNANT);

        return view('enseignant.commun.index', [
            'titre' => ReferentController::TITRE_INDEX
        ]);
    }

    /**
     * Renvoie la page contenant toutes les affectations de l'ensignant.
     */
    public function affectations()
    {
        Gate::authorize(ReferentController::GATE_ROLE_ENSEIGNANT);

        // Definitions des donnees a manipuer
        $entetes = [
            'Nom stagiaire',
            'Prenom stagiaire',
            'Annee',
            'Promotion',
            'Departement',
            'Sujet',
            'Entreprise',
            'Rapport',
            'Soutenance',
            'Synthese'
        ];

        // Recueration de l'identite de l'utilisateur
        $enseignant = Auth::user()->identite;
        
        // Recuperation des stages + classement par NOM de l'eutidnat
        $stages = Stage::with('etudiant')
        ->where(Stage::COL_REFERENT_ID, '=', $enseignant->id)
        ->get()
        ->sortBy('etudiant.nom');

        return view('enseignant.commun.affectations', [
            'titre'   => ReferentController::TITRE_AFFECTATIONS,
            'classe'  => Stage::class,
            'user'    => $enseignant,
            'entetes' => $entetes,
            'stages'  => $stages
        ]);
    }
}
