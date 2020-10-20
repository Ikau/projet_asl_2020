<?php

namespace App\Http\Controllers\Enseignant;

use App\Abstracts\Controllers\Enseignant\AbstractReferentController;
use App\Http\Middleware\VerifieEstEnseignant;
use App\Interfaces\InformationsNotification;
use App\Modeles\Stage;
use Illuminate\Support\Facades\Auth;

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
     * Indique a Lavel que toutes les fonctions de callback demandent un utilisateur
     * authentifie
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(VerifieEstEnseignant::class);
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
        return view('enseignant.commun.index', [
            'titre' => ReferentController::TITRE_INDEX
        ]);
    }

    /**
     * Renvoie la page contenant toutes les affectations de l'ensignant.
     */
    public function affectations()
    {
        // Definitions des donnees a manipuer
        $entetes = [
            '', // Vide pour une zone d'icone ou autre
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
        ->where([
            [Stage::COL_REFERENT_ID, '=', $enseignant->id],
            [Stage::COL_AFFECTATION_VALIDEE, '=', 1]
        ])->get()
        ->sortBy('etudiant.nom');

        return view('enseignant.commun.affectations', [
            'titre'   => ReferentController::TITRE_AFFECTATIONS,
            'user'    => $enseignant,
            'entetes' => $entetes,
            'stages'  => $stages
        ]);
    }
}
