<?php 

namespace App\Modeles;

use Illuminate\Database\Eloquent\Model;

use App\Abstracts\Modeles\AbstractRole;
use App\Utils\Constantes;

use App\User;
use App\Modeles\Privilege;

class Role extends AbstractRole
{

    /**
     * @var string Nom de la table associe au modele 'Role'
     */
    const NOM_TABLE = 'roles';

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

    /*
     * Indiquer a Laravel d'utiliser le nom de la table definie 
     */
    protected $table = Privilege::NOM_TABLE;

    /**
     * Renvoie la liste des utilisateurs ayant ce role
     *
     * @return array[App\User]
     */
    public function users()
    {
        // Args : modele de la relation, nom table pivot, nom colonne privilege_id, nom colonne user_id
        return $this->belongsToMany('App\User', Role::NOM_TABLE_PIVOT_ROLE_USER,
                                    Role::COL_PIVOT, User::COL_PIVOT);
    }

    /**
     * Renvoie la liste des privileges donnes a ce role
     *
     * @return App\Modeles\Privilege
     */
    public function privileges()
    {
        // Args : modele de la relation, nom table pivot, nom colonne privilege_id, nom colonne user_id
        return $this->belongsToMany('App\Modeles\Privilege', Role::NOM_TABLE_PIVOT_PRIVILEGE_ROLE,
                                    Role::COL_PIVOT, Privilege::COL_PIVOT);
    }
}