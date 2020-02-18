<?php

namespace App\Modeles;

use App\Modeles\Fiches\FicheSoutenance;
use Illuminate\Database\Eloquent\Model;

use App\Abstracts\Modeles\AbstractSoutenance;
use App\Utils\Constantes;

class Soutenance extends AbstractSoutenance
{
    /* ====================================================================
     *                        VALEURS DU MODELE
     * ====================================================================
     */
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
    protected $table = self::NOM_TABLE;

    /**
     * @var array[string] Liste des attributs a assigner manuellement.
     */
    protected $guarded = ['id'];

    /**
     * Valeurs par defaut des colonnes du modele 'Soutenance'.
     *
     * @var array[string]mixed
     */
    protected $attributes = [
        // Attributs propres au modele
        self::COL_ANNEE_ETUDIANT  => Constantes::INT_VIDE,
        self::COL_CAMPUS          => Constantes::STRING_VIDE,
        self::COL_COMMENTAIRE     => Constantes::STRING_VIDE,
        self::COL_CONFIDENTIELLE  => TRUE,
        self::COL_DATE            => Constantes::DATE_VIDE,
        self::COL_HEURE           => Constantes::HEURE_VIDE,
        self::COL_INVITES         => Constantes::STRING_VIDE,
        self::COL_NB_REPAS        => Constantes::INT_VIDE,
        self::COL_SALLE           => Constantes::STRING_VIDE,

        // Clefs etrangeres
        self::COL_CANDIDE_ID             => Constantes::ID_VIDE,
        //self::COL_CONTACT_ENTREPRISE_ID  => Constantes::ID_VIDE,
        self::COL_DEPARTEMENT_ID         => Constantes::ID_VIDE,
        self::COL_ETUDIANT_ID            => Constantes::ID_VIDE,
        self::COL_OPTION_ID              => Constantes::ID_VIDE,
        self::COL_REFERENT_ID            => Constantes::ID_VIDE,
    ];

    /**
     * Renvoie l'enseignant candide du jury.
     * @var App\Modeles\Enseignant
     */
    public function candide()
    {
        return $this->belongsTo(Enseignant::class, Soutenance::COL_CANDIDE_ID);
    }

    /**
     * Renvoie le contact entreprise qui assiste a la soutenance
     * @var App\Modeles\Contact
     */
    public function contact_entreprise()
    {
        return $this->belongsTo(Contact::class, Soutenance::COL_CONTACT_ENTREPRISE_ID);
    }

    /**
     * Renvoie l'etudiant qui passe la soutenance.
     * @var App\Modeles\Etudiant
     */
    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, Soutenance::COL_ETUDIANT_ID);
    }

    /**
     * Renvoie la fiche d'evaluation liee a cette soutenance
     * @var App\Modeles\FicheSoutenance
     */
    public function fiche()
    {
        return $this->hasOne(FicheSoutenance::class, FicheSoutenance::COL_SOUTENANCE_ID);
    }

    /**
     * Renvoie l'enseignant referent du jury.
     * @var App\Modeles\Enseignant
     */
    public function referent()
    {
        return $this->belongsTo(Enseignant::class, Soutenance::COL_REFERENT_ID);
    }

    /**
     * Renvoie le stage associe a cette soutenance
     * @var App\Modeles\Stage
     */
    public function stage()
    {
        return $this->hasOne(Stage::class, Stage::COL_SOUTENANCE_ID);
    }

}
