<?php

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\User;
use App\Abstracts\Modeles\AbstractContact;
use App\Interfaces\CompteUser;
use App\Utils\Constantes;

class Contact extends AbstractContact implements CompteUser
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
    protected $table = Contact::NOM_TABLE;

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
        Contact::COL_NOM       => Constantes::STRING_VIDE,
        Contact::COL_PRENOM    => Constantes::STRING_VIDE,
        Contact::COL_CIVILITE  => self::VAL_CIVILITE_VIDE,
        Contact::COL_TYPE      => self::VAL_TYPE_VIDE,
        Contact::COL_EMAIL     => Constantes::STRING_VIDE,
        Contact::COL_TELEPHONE => Constantes::STRING_VIDE,
        Contact::COL_ADRESSE   => Constantes::STRING_VIDE
    ];

    /**
     * Renvoie la liste des soutenances ou le contact est la scolarite INSA
     * @var array[App\Modeles\FicheEntreprise]
     */
    public function fiches_entreprise()
    {
        return $this->hasMany('App\Modeles\FicheEntreprise', FicheEntreprise::COL_CONTACT_INSA_ID);
    }

    /**
     * Renvoie la liste des soutenances ou le contact est maitre de stage
     * @var array[App\Modeles\Soutenance]
     */
    public function soutenances_mds()
    {
        return $this->hasMany('App\Modeles\Soutenance', Soutenance::COL_CONTACT_ENTREPRISE_ID);
    }

    /**
     * Renvoie la liste des stages ou le contact est maitre de stage
     * @var array[App\Modeles\Stage]
     */
    public function stages_mds()
    {
        return $this->hasMany('App\Modeles\Stage', Stage::COL_MDS_ID);
    }


    /* ====================================================================
     *                         INTERFACE 'CompteUser'
     * ====================================================================
     */
    /**
     * Renvoie le compte user associe au contact le cas echeant
     *
     * @return Null|App\User
     */
    public function user()
    {
        return $this->morphOne('App\User', User::COL_POLY_MODELE);
    }

}
