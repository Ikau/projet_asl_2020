<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Interfaces\Utilisateur;

use App\Modeles\Privilege;
use App\Modeles\Role;

class User extends Authenticatable implements Utilisateur, MustVerifyEmail
{
    use Notifiable;

    /**
     * @var string Nom de la table associee au model 'User'.
     */
    const NOM_TABLE = 'users';

    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_EMAIL            = 'email';
    const COL_EMAIL_VERIFIE_LE = 'email_verified_at'; // Nommage Laravel
    const COL_HASH_PASSWORD    = 'password';
    const COL_REMEMBER_TOKEN   = 'remember_token';    // Nommage Laravel

    /*
     * Nom des colonnes polymorphique 
     */
    const COL_POLY_MODELE      = 'userable';      // Nommage Laravel
    const COL_POLY_MODELE_ID   = 'userable_id';   // Nommage Laravel
    const COL_POLY_MODELE_TYPE = 'userable_type'; // Nommage Laravel

    /*
     * Nom de la table de jointure pour une relation Mane-to-Many 
     * Convention de nommage Laravel utilisee : ordre_alphabethique_class
     */
    const NOM_TABLE_PIVOT_PRIVILEGE_USER = 'privilege_user';
    const NOM_TABLE_PIVOT_ROLE_USER      = 'role_user';

    /*
     * Nom de la colonne dans la table de jointure
     * Convention de nommage Laravel utilise : class_id
     */
    const COL_PIVOT = 'user_id';

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'.
     * 
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * On indique a Laravel le nom de la table dans la BDD
     */
    protected $table = User::NOM_TABLE;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        User::COL_EMAIL,
        User::COL_HASH_PASSWORD,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        User::COL_REMEMBER_TOKEN,
        User::COL_HASH_PASSWORD
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        User::COL_EMAIL_VERIFIE_LE => 'datetime',
    ];

    /**
     * Indique l'adresse a laquelle renvoyer un utilisateur validant son email
     * 
     * @var string
     */
    protected $redirectTo = '/home';

    /* ====================================================================
     *                         INTERFACE 'UTILISATEUR'
     * ====================================================================
     */

    /**
     * Renvoie le type de l'utilisateur.
     *
     * @return App\UserType Renvoie une reference vers l'objet UserType auquel est rattache l'utilisateur
     */
    public function type()
    {
        return $this->belongsTo('App\UserType', User::COL_TYPE_ID);
    }

    /**
     * Renvoie les privileges de l'utilisateur.
     * 
     * @return array[App\Modeles\Privileges] Array de tous les privileges de l'utilisateur.
     */
    public function privileges()
    {
        // Args : modele de la relation, nom table pivot, nom colonne user_id, nom colonne privilege_id
        return $this->belongsToMany('App\Modeles\Privilege', User::NOM_TABLE_PIVOT_PRIVILEGE_USER,
                                    User::COL_PIVOT, Privilege::COL_PIVOT);
    }

    /**
     * Renvoie les roles de l'utilisateur. 
     * 
     * @return Collection[app\Modeles\Role]
     */
    public function roles()
    {
        // Args : modele de la relation, nom table pivot, nom colonne user_id, nom colonne privilege_id
        return $this->belongsToMany('App\Modeles\Role', User::NOM_TABLE_PIVOT_ROLE_USER,
                                    User::COL_PIVOT, Role::COL_PIVOT);
    }

    /**
     * Renvoie le modele associe au compte utilisateur.abnf
     * 
     * C'est une relation One-to-One polymorphique qui peut renvoyer :
     *  - un enseignant
     *  - un contact
     * Peut etre etendu a un etudiant si besoin
     * [DOC] : https://laravel.com/docs/6.x/eloquent-relationships#one-to-one-polymorphic-relations
     *
     * @return App\Modeles\Contact|App\Modeles\Enseignant
     */
    public function userable()
    {
        return $this->morphTo();
    }
}
