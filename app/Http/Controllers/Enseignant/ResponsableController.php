<?php

namespace App\Http\Controllers\Enseignant;
use App\Abstracts\Controllers\Enseignant\AbstractResponsableController;
use App\Http\Middleware\VerifieEstResponsable;
use App\Modeles\Departement;
use App\Modeles\Enseignant;
use App\Modeles\Option;
use App\Modeles\Stage;
use App\Notifications\AffectationAssignee;
use App\User;
use Illuminate\Support\Facades\Auth;

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
        $this->middleware(VerifieEstResponsable::class);
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
        return redirect()->route('stages.create');
    }

    /**
     * Renvoie la page listant toutes les affectations que le responsable peut modifier
     */
    public function getIndexAffectation()
    {
        // Recuperation du responsable courant
        $responsable = Auth::user()->identite;

        // Recuperation des id nuls
        $idDepartementNul = Departement::where(Departement::COL_INTITULE, '=', Departement::VAL_AUCUN)->first()->id;
        $idOptionNul      = Option::where(Option::COL_INTITULE, '=', Option::VAL_AUCUN)->first()->id;

        // Recuperation des stages geres par le responsable
        $stages = [];
        foreach(Stage::all() as $stage)
        {
            // Si l'enseignant est responsable du departement
            if($idDepartementNul !== $responsable[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID]
            && $stage->etudiant->departement->id === $responsable[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID])
            {
                $stages[] = $stage;
            }
            // Si l'enseignant est responsable de l'option
            else if($idOptionNul !== $responsable[Enseignant::COL_RESPONSABLE_OPTION_ID]
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
        $stage = Stage::find($idStage);
        if(null === $stage)
        {
            return redirect()->route('responsables.affectations.index')
                ->with('error', 'Impossible de recuperer le stage a valider');
        }

        // Verification du droit
        if(Auth::user()->cant('validerAffectation', $stage))
        {
            return redirect()->route('stages.show', $idStage)
                ->with('error', "Vous ne pouvez modifier que les stages de votre departement / option");
        }

        // Verification qu'il y ait bien un referent
        if($stage[Stage::COL_REFERENT_ID] === -1)
        {
            return redirect()->route('stages.show', $stage->id)
                ->with('error', "Il n'y a aucun referent assigné à ce stage !");
        }

        // Le stage a ete validee
        $stage[Stage::COL_AFFECTATION_VALIDEE] = TRUE;
        $stage->save();

        // On envoie la notification au referent
        $userEnseignant = User::where([
            [User::COL_POLY_MODELE_TYPE, '=', Enseignant::class],
            [User::COL_POLY_MODELE_ID, '=', $stage->referent->id]
        ])->first();
        $userEnseignant->notify(new AffectationAssignee($stage->id));

        return redirect()->route('stages.show', $idStage)
            ->with('success', 'Affectation validée !');
    }
}
