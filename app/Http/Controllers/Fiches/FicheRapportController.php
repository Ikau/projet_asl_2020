<?php

namespace App\Http\Controllers\Enseignant;

use App\Modeles\Fiches\FicheRapport;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

use App\Abstracts\Controllers\Fiches\AbstractFicheRapportController;

use App\Modeles\Enseignant;
use App\Modeles\Etudiant;
use App\Modeles\Stage;

use App\Utils\Constantes;

class FicheRapportController extends AbstractFicheRapportController
{

    /* ====================================================================
     *                         VALEURS DU MODELE
     * ====================================================================
     */
    /*
     * Valeurs attendues du tag <titles> pour les pages
     */
    const VAL_TITRE_SHOW = 'Enseignant - Rapport';

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
    public function show(int $idStage)
    {
        // Recuperation des donnees
        $stage = Stage::find($idStage);
        if(null === $stage)
        {
            abort('404');
        }

        $ficheRapport = $stage->fiche_rapport;
        if(null === $ficheRapport)
        {
            abort('404');
        }

        // Autorisation
        $this->verifieAcces(Auth::user(), $ficheRapport);

        return view('fiches.rapport.show', [
            'titre' => self::VAL_TITRE_SHOW,
            'fiche' => $ficheRapport,
            'stage' => $stage
        ]);
    }

    public function store($idProjet)
    {
        // TODO: Implement show() method.
    }

    public function edit($idProjet)
    {
        // TODO: Implement edit() method.
    }

    public function update($idProjet)
    {
        // TODO: Implement update() method.
    }

    public function tests($request)
    {
        // TODO: Implement tests() method.
    }

    /* ====================================================================
     *                     FONCTION AUXILIAIRES
     * ====================================================================
     */
    protected function normaliseInputsOptionnels(Request $request)
    {
        // TODO: Implement normaliseInputsOptionnels() method.
    }

    protected function validerForm(Request $request)
    {
        // TODO: Implement validerForm() method.
    }

    protected function getAttributsModele()
    {
        // TODO: Implement getAttributsModele() method.
    }

    /* ====================================================================
     *                     FONCTION PRIVEES
     * ====================================================================
     */
    private function verifieAcces(User $user, FicheRapport $ficheRapport)
    {
        Gate::authorize(Constantes::GATE_ROLE_ENSEIGNANT);

        if( $user->cant('show', $ficheRapport) )
        {
            abort('404');
        }
    }
}
