<?php

namespace App\Http\Controllers\Enseignant;
use App\Modeles\Departement;
use App\Modeles\Enseignant;
use App\Modeles\Option;
use App\Utils\Constantes;
use Illuminate\Support\Facades\Auth;
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
    const TITRE_INDEX_AFFECTATION    = 'Responsable - Liste des affectations';

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
    public function getCreateAffectation()
    {
        Gate::authorize(Constantes::GATE_ROLE_RESPONSABLE);

        return redirect()->route('stages.create');
    }

    /**
     * Renvoie la page listant toutes les affectations que le responsable peut modifier
     */
    public function getIndexAffectation()
    {
        Gate::authorize(Constantes::GATE_ROLE_RESPONSABLE);

        // Recuperation du responsable courant
        $responsable = Auth::user()->identite;

        // Recuperation des stages geres par le responsable
        $stages = [];
        foreach(Stage::all() as $stage)
        {
            // Si l'enseignant est responsable du departement
            if(Departement::VAL_AUCUN !== $responsable[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID]
            && $stage->etudiant->departement->id === $responsable[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID])
            {
                $stages[] = $stage;
            }

            // Si l'enseignant est responsable de l'option
            if(Option::VAL_AUCUN !== $responsable[Enseignant::COL_RESPONSABLE_OPTION_ID]
                && $stage->etudiant->option->id === $responsable[Enseignant::COL_RESPONSABLE_OPTION_ID])
            {
                $stages[] = $stage;
            }
        }

        // Entetes pour le tableau de la page
        $entetes = [
            '', // Vide pour les icones
            'Nom stagiaire',
            'Prenom stagiaire',
            'Annee',
            'Promotion',
            'Option',
            'Etat de l\'affectation',
            'Etat du stage',
            'Referent',
            'Entreprise',
            'Lieu'
        ];

        return view('enseignant.responsable.affectations', [
            'titre'   => self::TITRE_INDEX_AFFECTATION,
            'entetes' => $entetes,
            'stages'  => $stages
        ]);
    }

    /**
     * Valide une affectation si les conditions sont correctes
     */
    public function postValiderAffectation(int $idStage)
    {
        Gate::authorize(Constantes::GATE_ROLE_RESPONSABLE);

        $stage = Stage::find($idStage);
        if(null === $stage)
        {
            return redirect()->route('responsables.affectations.index')
                ->with('error', 'Impossible de recuperer le stage a valider');
        }

        $responsable = Auth::user()->identite;

        // On devrait mettre une policy
        if($responsable->departement_id !== 0
            && $stage->etudiant->departement->id  === $responsable->departement_id)
        {
            $stage[Stage::COL_AFFECTATION_VALIDEE] = true;
        }
        else if($responsable->option_id !== 0
            && $stage->etudiant->option->id === $responsable->option_id)
        {
            $stage[Stage::COL_AFFECTATION_VALIDEE] = true;
        }
        else
        {
            return redirect()->route('stages.show', $idStage)
                ->with('error', "Vous ne pouvez modifier que les stages de votre departement / option");
        }

        $stage->save();
        return redirect()->route('stages.show', $idStage)
            ->with('success', 'Affectation validée !');
    }
}
