<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractSoutenance;
use App\Utils\Constantes;

class Soutenance extends AbstractSoutenance
{
    /*
     * Nom des colonnes des clefs etrangeres 
     */
    const COL_REFERENT_ID           = 'referent_id';
    const COL_CANDIDE_ID            = 'candide_id';
    const COL_ETUDIANT_ID           = 'etudiant_id';
    const COL_CONTACT_ENTREPRISE_ID = 'contact_entreprise_id';

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
        'commentaire'           => Constantes::STRING_VIDE,
        'invites'               => Constantes::STRING_VIDE,
        'repas'                 => Constantes::INT_VIDE,
        'salle'                 => Constantes::STRING_VIDE,
        'heure'                 => Constantes::HEURE_VIDE,
        'date'                  => Constantes::DATE_VIDE,
        'departement_ou_option' => Constantes::STRING_VIDE,
        'nom_entreprise'        => Constantes::STRING_VIDE,
        'annee_etudiant'        => Constante::INT_VIDE,
        'campus'                => Constantes::STRING_VIDE,
        'confidentielle'        => FALSE,

        // Clefs etrangeres
        Soutenance::COL_REFERENT_ID            => Constantes::ID_VIDE,
        Soutenance::COL_CANDIDE_ID             => Constantes::ID_VIDE,
        Soutenance::COL_ETUDIANT_ID            => Constantes::ID_VIDE,
        Soutenance::COL_CONTACT_ENTREPRISE_ID  => Constantes::ID_VIDE,
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
