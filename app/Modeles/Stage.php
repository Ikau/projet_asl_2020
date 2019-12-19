<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractStage;
use App\Utils\Constantes;

class Stage extends AbstractStage
{
    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_ANNEE              = 'annee_etudiant';
    const COL_CONVENTION_ENVOYEE = 'convention_envoyee';
    const COL_CONVENTION_SIGNEE  = 'convention_signee';
    const COL_DATE_DEBUT         = 'date_debut';
    const COL_DATE_FIN           = 'date_fin';
    const COL_DUREE_SEMAINES     = 'duree_semaines';
    const COL_GRATIFICATION      = 'gratification';
    const COL_INTITULE           = 'intitule';
    const COL_LIEU               = 'lieu';
    const COL_MOYEN_RECHERCHE    = 'moyen_recherch';
    const COL_RESUME             = 'resume';


    /*
     * Nom des colonnes des clefs etrangeres de Stage 
     */
    const COL_REFERENT_ID   = 'referent_id';
    const COL_ETUDIANT_ID   = 'etudiant_id';
    //const COL_ENTREPRISE_ID = 'entreprise_id';
    //const COL_MDS_ID        = 'maitre_de_stage_id';

    /**
     * @var string Nom de la table associe au modele 'Stage'
     */
    const NOM_TABLE = 'stages';

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'.
     * 
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * @var string Nom de la table associee au model 'Stage'.
     */
    protected $table = Stage::NOM_TABLE;

    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = [];

    /**
     * Valeurs par defaut des colonnes du modele 'Stage'.
     */
    protected $attributes = [
        // Attributs propres au modele
        Stage::COL_ANNEE              => Constantes::INT_VIDE,
        Stage::COL_CONVENTION_ENVOYEE => FALSE,
        Stage::COL_CONVENTION_SIGNEE  => FALSE,
        Stage::COL_DATE_DEBUT         => Constantes::DATE_VIDE,
        Stage::COL_DATE_FIN           => Constantes::DATE_VIDE,
        Stage::COL_DUREE_SEMAINES     => Constantes::INT_VIDE,
        Stage::COL_GRATIFICATION      => Constantes::FLOAT_VIDE,
        Stage::COL_INTITULE           => Constantes::STRING_VIDE,
        Stage::COL_LIEU               => Constantes::STRING_VIDE,
        Stage::COL_MOYEN_RECHERCHE    => Constantes::STRING_VIDE,
        Stage::COL_RESUME             => Constantes::STRING_VIDE,
        
        // Clefs etrangeres
        Stage::COL_REFERENT_ID   => Constantes::ID_VIDE,
        Stage::COL_ETUDIANT_ID   => Constantes::ID_VIDE,
        //Stage::COL_ENTREPRISE_ID => Constantes::ID_VIDE,
        //Stage::COL_MDS_ID        => Constantes::ID_VIDE,
    ];

    /**
     * Renvoie l'entreprise associee au stage
     * @var App\Modeles\Entreprise
     */
    public function entreprise()
    {
        return $this->belongsTo('App\Modeles\Entreprise', Stage::COL_ENTREPRISE_ID);
    }

    /**
     * Renvoie l'etudiant associe au stage
     * @var App\Modeles\Etudiant
     */
    public function etudiant()
    {
        return $this->belongsTo('App\Modeles\Etudiant', Stage::COL_ETUDIANT_ID);
    }

    /**
     * Renvoie la fiche entreprise du stage
     * @var App\Modeles\FicheEntreprise
     */
    public function fiche_entreprise()
    {
        return $this->hasOne('App\Modeles\FicheEntreprise', FicheEntreprise::COL_STAGE_ID);
    }

    /**
     * Renvoie la fiche rapport du stage
     * @var App\Modeles\FicheRapport
     */
    public function fiche_rapport()
    {
        return $this->hasOne('App\Modeles\FicheRapport', FicheRapport::COL_STAGE_ID);
    }
    
    /**
     * Renvoie la fiche soutenance du stage
     * @var App\Modeles\FicheSoutenance
     */
    public function fiche_soutenance()
    {
        return $this->hasOne('App\Modeles\FicheSoutenance', FicheSoutenance::COL_STAGE_ID);
    }

    /**
     * Renvoie la fiche synthese du stage
     * @var App\Modeles\FicheSynthese
     */
    public function fiche_synthese()
    {
        return $this->hasOne('App\Modeles\FicheSynthese', FicheSynthese::COL_STAGE_ID);
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
     * @var App\Modeles\Enseignant
     */
    public function referent()
    {
        return $this->belongsTo('App\Modeles\Enseignant', Stage::COL_REFERENT_ID);
    }
}
