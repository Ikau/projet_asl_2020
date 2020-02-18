<?php

namespace App\Modeles;

use App\Interfaces\ArrayValeurs;
use Illuminate\Database\Eloquent\Model;

use App\Abstracts\Modeles\AbstractPrivilege;
use App\Utils\Constantes;

use App\User;
use App\Modeles\Role;

class Privilege extends AbstractPrivilege implements ArrayValeurs
{

    /* ====================================================================
     *                        VALEURS DU MODELE
     * ====================================================================
     */
    const VAL_ENSEIGNANT = 'referent';

    /**
     * @inheritDoc
     */
    public static function getValeurs()
    {
        return [
            self::VAL_ENSEIGNANT
        ];
    }


    /* ====================================================================
     *                          BASE DE DONNEES
     * ====================================================================
     */
    /*
     * Nom des colonnes de la tables
     */
    const COL_INTITULE = 'intitule';

    /**
     * @var string Nom de la table associe au modele 'Privilege'
     */
    const NOM_TABLE = 'privileges';

    //Indiquer a Laravel d'utiliser le nom de la table definie
    protected $table = self::NOM_TABLE;

    /*
     * Nom de la table de jointure pour une relation Mane-to-Many
     * Convention de nommage Laravel utilisee : ordre_alphabethique_class
     */
    const NOM_TABLE_PIVOT_PRIVILEGE_USER = 'privilege_user';
    const NOM_TABLE_PIVOT_PRIVILEGE_ROLE = 'privilege_role';

    /*
     * Nom de la colonne dans la table de jointure
     * Convention de nommage Laravel utilise : class_id
     */
    const COL_PIVOT = 'privilege_id';

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
        Privilege::COL_INTITULE => Constantes::STRING_VIDE
    ];

    /* ====================================================================
     *                          RELATIONS ELOQUENT
     * ====================================================================
     */

    /**
     * Renvoie la liste des utilisateurs ayant le privilege associe
     *
     * @return array[App\User]
     */
    public function users()
    {
        // Args : modele de la relation, nom table pivot, nom colonne privilege_id, nom colonne user_id
        return $this->belongsToMany(User::class, Privilege::NOM_TABLE_PIVOT_PRIVILEGE_USER,
                                    Privilege::COL_PIVOT, User::COL_PIVOT);
    }

    /**
     * Renvoie la liste des roles ayant le privilege associe
     *
     * @return App\Modeles\Role
     */
    public function roles()
    {
        // Args : modele de la relation, nom table pivot, nom colonne privilege_id, nom colonne user_id
        return $this->belongsToMany(Role::class, Privilege::NOM_TABLE_PIVOT_PRIVILEGE_ROLE,
                                    Privilege::COL_PIVOT, Role::COL_PIVOT);
    }
}
