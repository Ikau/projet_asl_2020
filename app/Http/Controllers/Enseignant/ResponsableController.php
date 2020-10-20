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

    /*
     * Messages affiches en cas d'erreurs
     */
    const MESSAGE_AFFECTATION_AUCUN_REFERENT  = 'Il n\'y a aucun referent assigné à ce stage !';
    const MESSAGE_AFFECTATION_INEXISTANTE     = 'Impossible de recuperer le stage a valider';
    const MESSAGE_AFFECTATION_NON_RESPONSABLE = 'Vous devez être responsable de l\'option ou du departement pour valider';
    const MESSAGE_AFFECTAATION_VALIDEE        = 'L\'affectation de stage a été validée avec succès !';

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

        // Recuperation des stages geres par le responsable
        $stages = [];
        foreach(Stage::all() as $stage)
        {
            // Si l'enseignant est responsable du departement
            if(null !== $responsable->responsable_departement
            && $stage->etudiant->departement->id === $responsable->responsable_departement->id)
            {
                $stages[] = $stage;
            }
            // Si l'enseignant est responsable de l'option
            else if(null !== $responsable->responsable_option
                && $stage->etudiant->option->id === $responsable->responsable_option->id)
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
                ->with('error', self::MESSAGE_AFFECTATION_INEXISTANTE);
        }

        // Verification du droit
        if(Auth::user()->cant('validerAffectation', $stage))
        {
            return redirect()->route('stages.show', $idStage)
                ->with('error', self::MESSAGE_AFFECTATION_NON_RESPONSABLE);
        }

        // Verification qu'il y ait bien un referent
        if($stage[Stage::COL_REFERENT_ID] === null)
        {
            return redirect()->route('stages.show', $stage->id)
                ->with('error', self::MESSAGE_AFFECTATION_AUCUN_REFERENT);
        }

        // Le stage a ete validee
        $stage[Stage::COL_AFFECTATION_VALIDEE] = TRUE;
        $stage->save();

        $userEnseignant = User::where([
            [User::COL_POLY_MODELE_TYPE, '=', Enseignant::class],
            [User::COL_POLY_MODELE_ID, '=', $stage->referent->id]
        ])->first();
        $userEnseignant->notify(new AffectationAssignee($stage->id));

        return redirect()->route('stages.show', $idStage)
            ->with('success', self::MESSAGE_AFFECTAATION_VALIDEE);
    }
}
