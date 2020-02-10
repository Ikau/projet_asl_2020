<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\Modeles\AbstractSoutenance;
use App\Utils\Constantes;

class Soutenance extends AbstractSoutenance
{

    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_ANNEE_ETUDIANT  = 'annee_etudiant';
    const COL_CAMPUS          = 'campus';
    const COL_COMMENTAIRE     = 'commentaire';
    const COL_CONFIDENTIELLE  = 'confidentielle';
    const COL_DATE            = 'date';
    const COL_HEURE           = 'heure';
    const COL_INVITES         = 'invites';
    const COL_NB_REPAS        = 'repas';
    const COL_SALLE           = 'salle';
    
    /*
     * Nom des colonnes des clefs etrangeres 
     */
    const COL_CANDIDE_ID            = 'candide_id';
    //const COL_CONTACT_ENTREPRISE_ID = 'departement';
    const COL_DEPARTEMENT_ID        = 'departement_id';
    const COL_ETUDIANT_ID           = 'etudiant_id';
    const COL_OPTION_ID             = 'option_etudiant';
    const COL_REFERENT_ID           = 'referent_id';

    /**
     * @var string Nom de la table associe au modele 'Soutenance'
     */
    const NOM_TABLE = 'soutenances';

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'.
     * 
     * @var bool Gestion des timestamps.
     */
    public $timestamps = false;

    /**
     * @var string Nom de la table associee au modele 'Soutenance'.
     */
    protected $table = Soutenance::NOM_TABLE;

    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = [];
    
    /**
     * Valeurs par defaut des colonnes du modele 'Soutenance'.
     * 
     * @var array[string]mixed
     */
    protected $attributes = [
        // Attributs propres au modele
        Soutenance::COL_ANNEE_ETUDIANT  => Constantes::INT_VIDE,
        Soutenance::COL_CAMPUS          => Constantes::STRING_VIDE,
        Soutenance::COL_COMMENTAIRE     => Constantes::STRING_VIDE,
        Soutenance::COL_CONFIDENTIELLE  => TRUE,
        Soutenance::COL_DATE            => Constantes::DATE_VIDE,
        Soutenance::COL_HEURE           => Constantes::HEURE_VIDE,
        Soutenance::COL_INVITES         => Constantes::STRING_VIDE,
        Soutenance::COL_NB_REPAS        => Constantes::INT_VIDE,
        Soutenance::COL_SALLE           => Constantes::STRING_VIDE,

        // Clefs etrangeres
        Soutenance::COL_CANDIDE_ID             => Constantes::ID_VIDE,
        //Soutenance::COL_CONTACT_ENTREPRISE_ID  => Constantes::ID_VIDE,
        Soutenance::COL_DEPARTEMENT_ID         => Constantes::ID_VIDE,
        Soutenance::COL_ETUDIANT_ID            => Constantes::ID_VIDE,
        Soutenance::COL_OPTION_ID              => Constantes::ID_VIDE,
        Soutenance::COL_REFERENT_ID            => Constantes::ID_VIDE,
    ];

    /**
     * Renvoie l'enseignant candide du jury.
     * @var App\Modeles\Enseignant
     */
    public function candide()
    {
        return $this->belongsTo('App\Modeles\Enseignant', Soutenance::COL_CANDIDE_ID);
    }

    /**
     * Renvoie le contact entreprise qui assiste a la soutenance
     * @var App\Modeles\Contact
     */
    public function contact_entreprise()
    {
        return $this->belongsTo('App\Modeles\Contact', Soutenance::COL_CONTACT_ENTREPRISE_ID);
    }

    /**
     * Renvoie l'etudiant qui passe la soutenance.
     * @var App\Modeles\Etudiant
     */
    public function etudiant()
    {
        return $this->belongsTo('App\Modeles\Etudiant', Soutenance::COL_ETUDIANT_ID);
    }

    /**
     * Renvoie la fiche d'evaluation liee a cette soutenance
     * @var App\Modeles\FicheSoutenance
     */
    public function fiche()
    {
        return $this->hasOne('App\Modeles\FicheSoutenance', FicheSoutenance::COL_SOUTENANCE_ID);
    }

    /**
     * Renvoie l'enseignant referent du jury.
     * @var App\Modeles\Enseignant
     */
    public function referent()
    {
        return $this->belongsTo('App\Modeles\Enseignant', Soutenance::COL_REFERENT_ID);
    }

    /**
     * Renvoie le stage associe a cette soutenance
     * @var App\Modeles\Stage
     */
    public function stage()
    {
        return $this->hasOne('App\Modeles\Stage', Stage::COL_SOUTENANCE_ID);
    }

}
