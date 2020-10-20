<?php

namespace App\Http\Controllers\Scolarite;

use App\Abstracts\Controllers\Scolarite\AbstractScolariteController;
use App\Http\Middleware\VerifieEstScolarite;
use App\Modeles\Departement;
use App\Modeles\Stage;

class ScolariteController extends AbstractScolariteController
{
    /* ------------------------------------------------------------------
     *                       Valeurs du modele
     * ------------------------------------------------------------------
     */
    /*
     * Valeur des differents titres des pages du controller
     */
    const VAL_TITRE_INDEX       = 'Scolarité - Accueil';
    const VAL_TITRE_AFFECTTIONS = 'Scolarité - Affectations';

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
        $entetes = [
            'Année',
            'Stagiaire',
            'Promotion',
            'Referent',
            'Entreprise',
            'Rapport',
            'Soutenance',
            'Synthese'
        ];

        // Recuperation des stages
        $stages = [
            'sti' => [],
            'mri' => []
        ];
        foreach(Stage::all() as $stage)
        {
            if($stage->etudiant->departement->intitule === Departement::VAL_STI)
            {
                $stages['sti'][] = $stage;
            }
            else
            {
                $stages['mri'][] = $stage;
            }
        }

        return view('scolarite.affectations', [
            'titre'   => self::VAL_TITRE_AFFECTTIONS,
            'entetes' => $entetes,
            'stages'  => $stages
        ]);
    }
}
