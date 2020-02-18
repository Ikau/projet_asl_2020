<?php

namespace App\Modeles;

use App\Interfaces\ArrayValeurs;
use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Abstracts\Modeles\AbstractContact;
use App\Interfaces\CompteUser;
use App\Modeles\Fiches\FicheEntreprise;
use App\Utils\Constantes;

class Contact extends AbstractContact implements CompteUser, ArrayValeurs
{
    /* ====================================================================
     *                        VALEURS DU MODELE
     * ====================================================================
     */
    /*
     * Valeurs possibles pour le champ 'civilite'
     */
    const VAL_CIVILITE_VIDE     = 0;
    const VAL_CIVILITE_MADAME   = 1;
    const VAL_CIVILITE_MONSIEUR = 2;

    /*
     * Valeurs possibles pour le champ 'type'
     */
    const VAL_TYPE_VIDE            = 0;
    const VAL_TYPE_INSA            = 1;
    const VAL_TYPE_ENTREPRISE      = 2;
    const VAL_TYPE_MAITRE_DE_STAGE = 3;

    /**
     * @inheritDoc
     */
    public static function getValeurs()
    {
        return [
            self::VAL_CIVILITE_VIDE,
            self::VAL_CIVILITE_MADAME,
            self::VAL_CIVILITE_MONSIEUR,
            self::VAL_TYPE_VIDE,
            self::VAL_TYPE_INSA,
            self::VAL_TYPE_ENTREPRISE,
            self::VAL_TYPE_MAITRE_DE_STAGE,
        ];
    }

    /* ====================================================================
     *                          BASE DE DONNEES
     * ====================================================================
     */
    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_NOM       = 'nom';
    const COL_PRENOM    = 'prenom';
    const COL_CIVILITE  = 'civilite';
    const COL_TYPE      = 'type';
    const COL_EMAIL     = 'email';
    const COL_TELEPHONE = 'telephone';
    const COL_ADRESSE   = 'adresse';

    /**
     * @var string Nom de la table associe au modele 'Contact'
     */
    const NOM_TABLE = 'contacts';

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'
     *
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * @var string Nom de la table associee au modele 'Contact'
     */
    protected $table = self::NOM_TABLE;

    /**
     * @var array[string] Liste des attributs a assigner manuellement
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Valeurs par defaut des colonnes du modele 'Contact'
     *
     * @var array[string]mixed
     */
    protected $attributes = [
        self::COL_NOM       => Constantes::STRING_VIDE,
        self::COL_PRENOM    => Constantes::STRING_VIDE,
        self::COL_CIVILITE  => self::VAL_CIVILITE_VIDE,
        self::COL_TYPE      => self::VAL_TYPE_VIDE,
        self::COL_EMAIL     => Constantes::STRING_VIDE,
        self::COL_TELEPHONE => Constantes::STRING_VIDE,
        self::COL_ADRESSE   => Constantes::STRING_VIDE
    ];

    /**
     * Renvoie la liste des soutenances ou le contact est la scolarite INSA
     * @var array(App\Modeles\FicheEntreprise)
     */
    public function fiches_entreprise()
    {
        return $this->hasMany(FicheEntreprise::class, FicheEntreprise::COL_CONTACT_INSA_ID);
    }

    /**
     * Renvoie la liste des soutenances ou le contact est maitre de stage
     * @var array(App\Modeles\Soutenance)
     */
    public function soutenances_mds()
    {
        return $this->hasMany(Soutenance::class, Soutenance::COL_CONTACT_ENTREPRISE_ID);
    }

    /**
     * Renvoie la liste des stages ou le contact est maitre de stage
     * @var array(App\Modeles\Stage)
     */
    public function stages_mds()
    {
        return $this->hasMany(Stage::class, Stage::COL_MDS_ID);
    }


    /* ====================================================================
     *                         INTERFACE 'CompteUser'
     * ====================================================================
     */
    /**
     * Renvoie le compte user associe au contact le cas echeant
     *
     * @return User|\Illuminate\Database\Eloquent\Relations\MorphOne|Null
     */
    public function user()
    {
        return $this->morphOne(User::class, User::COL_POLY_MODELE);
    }

}
