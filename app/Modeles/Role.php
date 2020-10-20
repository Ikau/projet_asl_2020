<?php

namespace App\Modeles;

use App\Abstracts\Modeles\AbstractRole;
use App\Interfaces\ArrayValeurs;
use App\User;
use App\Utils\Constantes;

class Role extends AbstractRole implements ArrayValeurs
{
    /* ====================================================================
     *                        VALEURS DU MODELE
     * ====================================================================
     */
    const VAL_ADMIN            = 'admin';
    const VAL_ENSEIGNANT       = 'enseignant';
    const VAL_RESP_OPTION      = 'responsable_option';
    const VAL_RESP_DEPARTEMENT = 'responsable_departement';
    const VAL_SCOLARITE        = 'scolarite';

    /**
     * Fonction auxiliaire permettant d'avoir une liste des intitules possibles
     *
     * @return array(string)
     */
    public static function getValeurs()
    {
        return [
            self::VAL_ADMIN,
            self::VAL_ENSEIGNANT,
            self::VAL_RESP_DEPARTEMENT,
            self::VAL_RESP_OPTION,
            self::VAL_SCOLARITE
        ];
    }

    /* ====================================================================
     *                          BASE DE DONNEES
     * ====================================================================
     */
    /**
     * @var string Nom de la table associe au modele 'Role'
     */
    const NOM_TABLE = 'roles';

    // Indiquer a Laravel d'utiliser le nom de la table definie
    protected $table = self::NOM_TABLE;

    /*
     * Nom des colonnes de la tables
     */
    const COL_INTITULE = 'intitule';

    /*
     * Nom de la table de jointure pour une relation Mane-to-Many
     * Convention de nommage Laravel utilisee : ordre_alphabethique_class
     */
    const NOM_TABLE_PIVOT_PRIVILEGE_ROLE = 'privilege_role';
    const NOM_TABLE_PIVOT_ROLE_USER      = 'role_user';

    /*
     * Nom de la colonne dans la table de jointure
     * Convention de nommage Laravel utilise : class_id
     */
    const COL_PIVOT = 'role_id';

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'
     *
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * @var array[string] Liste des attributs a assigner manuellement
     */
    protected $guarded = [
        'id',
    ];

    /**
     * Valeurs par defaut pour un constructeur vide
     */
    protected $attributes = [
        self::COL_INTITULE => Constantes::STRING_VIDE
    ];

    /* ====================================================================
     *                          RELATIONS ELOQUENT
     * ====================================================================
     */

    /**
     * Renvoie la liste des utilisateurs ayant ce role
     *
     * @return array[App\User]
     */
    public function users()
    {
        // Args : modele de la relation, nom table pivot, nom colonne privilege_id, nom colonne user_id
        return $this->belongsToMany(User::class, Role::NOM_TABLE_PIVOT_ROLE_USER,
                                    Role::COL_PIVOT, User::COL_PIVOT);
    }

    /**
     * Renvoie la liste des privileges donnes a ce role
     *
     * @return App\Modeles\Privilege
     */
    public function privileges()
    {
        // Args : modele de la relation, nom table pivot, nom colonne privilege_id, nom colonne privilege_id
        return $this->belongsToMany(Privilege::class, Role::NOM_TABLE_PIVOT_PRIVILEGE_ROLE,
                                    Role::COL_PIVOT, Privilege::COL_PIVOT);
    }
}
