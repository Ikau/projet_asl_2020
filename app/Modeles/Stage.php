<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractStage;
use App\Utils\Constantes;

class Stage extends AbstractStage
{
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
        'annee_etudiant'                => Constantes::INT_VIDE,
        'date_debut'                    => Constantes::DATE_VIDE,
        'date_fin'                      => Constantes::DATE_VIDE,
        'sujet'                         => Constantes::STRING_VIDE,
        'convention_envoyee_entreprise' => FALSE,
        'retour_convention_signee'      => FALSE,
        'gratification'                 => Constantes::FLOAT_VIDE,
        'nombre_de_semaines'            => Constantes::INT_VIDE,
        'moyen_recherche_stage'         => Constantes::STRING_VIDE,

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
