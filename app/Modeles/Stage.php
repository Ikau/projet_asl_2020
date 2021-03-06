<?php

namespace App\Modeles;

use App\Abstracts\Modeles\AbstractStage;
use App\Modeles\Fiches\FicheEntreprise;
use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Fiches\FicheSoutenance;
use App\Modeles\Fiches\FicheSynthese;
use App\Utils\Constantes;

class Stage extends AbstractStage
{
    /* ====================================================================
     *                          BASE DE DONNEES
     * ====================================================================
     */
    /*
     * Nom des colonnes dans la base de donnees
     */
    // Elements obligatoires a la creation
    const COL_ANNEE          = 'annee_etudiant';
    const COL_DATE_DEBUT     = 'date_debut';
    const COL_DATE_FIN       = 'date_fin';
    const COL_DUREE_SEMAINES = 'duree_semaines';
    const COL_GRATIFICATION  = 'gratification';
    const COL_INTITULE       = 'intitule';
    const COL_LIEU           = 'lieu';
    const COL_RESUME         = 'resume';

    // Elements optionnels a la creation
    const COL_AFFECTATION_VALIDEE = 'affectation_validee';
    const COL_CONVENTION_ENVOYEE  = 'convention_envoyee';
    const COL_CONVENTION_SIGNEE   = 'convention_signee';
    const COL_MOYEN_RECHERCHE     = 'moyen_recherche';


    /*
     * Nom des colonnes des clefs etrangeres de Stage
     */
    // Elements obligatoires a la creation
    const COL_ETUDIANT_ID   = 'etudiant_id';

    // Elements optionnels a la creation
    const COL_REFERENT_ID   = 'referent_id';

    //const COL_ENTREPRISE_ID = 'entreprise_id';
    //const COL_MDS_ID        = 'maitre_de_stage_id';

    /* ====================================================================
     *                   STRUCTURE DE LA TABLE DU MODELE
     * ====================================================================
     */
    /**
     * @var string Nom de la table associe au modele 'Stage'
     */
    const NOM_TABLE = 'stages';

    // On indique a Laravel d'utiliser le nom que l'on a defini
    protected $table = self::NOM_TABLE;

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'.
     *
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = ['id'];

    /**
     * Valeurs par defaut des colonnes du modele 'Stage'.
     */
    protected $attributes = [
        // Attributs propres au modele
        self::COL_AFFECTATION_VALIDEE => FALSE,
        self::COL_ANNEE               => Constantes::INT_VIDE,
        self::COL_CONVENTION_ENVOYEE  => FALSE,
        self::COL_CONVENTION_SIGNEE   => FALSE,
        self::COL_DATE_DEBUT          => Constantes::DATE_VIDE,
        self::COL_DATE_FIN            => Constantes::DATE_VIDE,
        self::COL_DUREE_SEMAINES      => Constantes::INT_VIDE,
        self::COL_GRATIFICATION       => Constantes::FLOAT_VIDE,
        self::COL_INTITULE            => Constantes::STRING_VIDE,
        self::COL_LIEU                => Constantes::STRING_VIDE,
        self::COL_MOYEN_RECHERCHE     => Constantes::STRING_VIDE,
        self::COL_RESUME              => Constantes::STRING_VIDE,

        // Clefs etrangeres
        self::COL_REFERENT_ID   => Constantes::ID_VIDE,
        self::COL_ETUDIANT_ID   => Constantes::ID_VIDE,
        //self::COL_ENTREPRISE_ID => Constantes::ID_VIDE,
        //self::COL_MDS_ID        => Constantes::ID_VIDE,
    ];

    /* ====================================================================
     *                          RELATIONS ELOQUENT
     * ====================================================================
     */

    /**
     * Renvoie l'entreprise associee au stage
     * @var App\Modeles\Entreprise
     */
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class, Stage::COL_ENTREPRISE_ID);
    }

    /**
     * Renvoie l'etudiant associe au stage
     * @var App\Modeles\Etudiant
     */
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, Stage::COL_ETUDIANT_ID);
    }

    /**
     * Renvoie la fiche entreprise du stage
     * @var App\Modeles\FicheEntreprise
     */
    public function fiche_entreprise()
    {
        return $this->hasOne(FicheEntreprise::class, FicheEntreprise::COL_STAGE_ID);
    }

    /**
     * Renvoie la fiche rapport du stage
     * @var App\Modeles\FicheRapport
     */
    public function fiche_rapport()
    {
        return $this->hasOne(FicheRapport::class, FicheRapport::COL_STAGE_ID);
    }

    /**
     * Renvoie la fiche soutenance du stage
     * @var App\Modeles\FicheSoutenance
     */
    public function fiche_soutenance()
    {
        return $this->hasOne(FicheSoutenance::class, FicheSoutenance::COL_STAGE_ID);
    }

    /**
     * Renvoie la fiche synthese du stage
     * @var App\Modeles\FicheSynthese
     */
    public function fiche_synthese()
    {
        return $this->hasOne(FicheSynthese::class, FicheSynthese::COL_STAGE_ID);
    }

    /**
     * Renvoie le contact ayant le role de maitre de stage
     * @var App\Modeles\Contact
     */
    public function maitre_de_stage()
    {
        return $this->belongsTo('App\Modeles\Contact', Stage::COL_MDS_ID);
    }

    /**
     * Renvoie l'enseignant referent associe au stage.
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referent()
    {
        return $this->belongsTo(Enseignant::class, Stage::COL_REFERENT_ID);
    }
}
