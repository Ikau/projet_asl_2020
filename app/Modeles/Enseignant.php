<?php

namespace App\Modeles;

use App\Abstracts\Modeles\AbstractEnseignant;
use App\Interfaces\CompteUser;
use App\User;
use App\Utils\Constantes;

class Enseignant extends AbstractEnseignant implements CompteUser
{

    /* ====================================================================
     *                        VALEURS DU MODELE
     * ====================================================================
     */

    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_NOM    = 'nom';
    const COL_PRENOM = 'prenom';
    const COL_EMAIL  = 'email';

    /*
     * Nom des colonnes des clefs etrangeres
     */
    const COL_RESPONSABLE_DEPARTEMENT_ID = 'departement_id';
    const COL_RESPONSABLE_OPTION_ID      = 'option_id';

    /**
     * @var string Nom de la table associe au modele 'Enseignant'
     */
    const NOM_TABLE = 'enseignants';

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'
     *
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * @var string Nom de la table associee au modele 'Enseignant'
     */
    protected $table = Enseignant::NOM_TABLE;

    /**
     * @var array[string] Liste des attributs a assigner manuellement
     */
    protected $guarded = [
        'id',
    ];

    /**
     * Valeurs par defaut des colonnes du modele 'Enseignant'
     *
     * @var array[string]string
     */
    protected $attributes = [
        self::COL_NOM                        => Constantes::STRING_VIDE,
        self::COL_PRENOM                     => Constantes::STRING_VIDE,
        self::COL_EMAIL                      => Constantes::STRING_VIDE,

        self::COL_RESPONSABLE_DEPARTEMENT_ID => Constantes::ID_VIDE,
        self::COL_RESPONSABLE_OPTION_ID      => Constantes::ID_VIDE
    ];

    /* ====================================================================
     *                      INTERFACE 'CompteUser'
     * ====================================================================
     */

    /**
     * Renvoie le modele user associe a l'enseignant
     */
    public function user()
    {
        return $this->morphOne(User::class, User::COL_POLY_MODELE);
    }

    /* ====================================================================
     *                             RELATIONS
     * ====================================================================
     */

    /**
     * Renvoie l'option dont l'enseignant est responsable
     * @var array[App\Modeles\Option]
     */
    public function responsable_option()
    {
        return $this->belongsTo(Option::class, Enseignant::COL_RESPONSABLE_OPTION_ID);
    }

    /**
     * Renvoie le departement dont l'enseignant est responsable
     * @var array[App\Modeles\Departement]
     */
    public function responsable_departement()
    {
        return $this->belongsTo(Departement::class, Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID);
    }

    /**
     * Renvoie la liste des soutenances dont l'enseignant est candide.
     * @var array[App\Modeles\Soutenance]
     */
    public function soutenances_candide()
    {
        return $this->hasMany(Soutenance::class, Soutenance::COL_CANDIDE_ID);
    }

    /**
     * Renvoie la liste des soutenances dont l'enseignant est referent.
     * @var array[App\Modeles\Soutenance]
     */
    public function soutenances_referent()
    {
        return $this->hasMany(Soutenance::class, Soutenance::COL_REFERENT_ID);
    }

    /**
     * Renvoie la liste des stages dont l'enseignant est referent.
     * @var array[App\Modeles\Stage]
     */
    public function stages()
    {
        return $this->hasMany(Stage::class, Stage::COL_REFERENT_ID);
    }


}
