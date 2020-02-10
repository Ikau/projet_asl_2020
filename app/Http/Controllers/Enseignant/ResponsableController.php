<?php

namespace App\Http\Controllers\Enseignant;
use App\Utils\Constantes;
use Illuminate\Support\Facades\Gate;

use App\Modeles\Etudiant;
use App\Modeles\Stage;

use App\Abstracts\Controllers\Enseignant\AbstractResponsableController;

class ResponsableController extends AbstractResponsableController
{

    /* ====================================================================
     *                         VALEURS DU MODELE
     * ====================================================================
     */
    /*
     * Valeur attendue du tag <title> pour les pages
     */
    const TITRE_GET_FORM_AFFECTATION = 'Responsable - Creer une affectation';

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
     * Renvoie la page avec le formulaire de creation d'une affectation
     */
    public function getFormAffectation()
    {
        Gate::authorize(Constantes::GATE_ROLE_RESPONSABLE);

        return redirect()->route('stages.create');
    }
}
