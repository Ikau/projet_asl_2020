<?php

namespace App;

use App\Interfaces\Authentification;
use App\Interfaces\Utilisateur;
use App\Modeles\Privilege;
use App\Modeles\Role;
use App\Utils\Constantes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * La classe User presentée est la classe 'User' livre par defaut par le framework Laravel
 *
 * Le choix a ete fait d'utiliser ce modele Eloquent parce que beaucoup de modules reutilisent cette classe
 * Pour eviter de se prendre la tete en enregistrant une nouvelle classe, on utilise donc ce modele par defaut
 *
 * Bien sur, le fait d'utiliser cette classe risque de faire apparaitre des problemes en cas de mise a niveau de Laravel
 * C'est pour cette raison que l'on utilisera beaucoup d'interfaces pour lister les fonctions personnalisees a implementer
 */
class User extends Authenticatable implements Utilisateur, Authentification, MustVerifyEmail
{
    use Notifiable;


    /* ====================================================================
     *                          BASE DE DONNEES
     * ====================================================================
     */
    /**
     * @var string Nom de la table associee au model 'User'.
     */
    const NOM_TABLE = 'users';

    //On indique a Laravel le nom de la table dans la BDD
    protected $table = self::NOM_TABLE;

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
    const COL_POLY_MODELE      = 'identite';      // Nommage Laravel
    const COL_POLY_MODELE_ID   = 'identite_id';   // Nommage Laravel
    const COL_POLY_MODELE_TYPE = 'identite_type'; // Nommage Laravel

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

    /* ====================================================================
     *                          PROPRIETES
     * ====================================================================
     */
    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'.
     *
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * Valeurs par defaut des colonnes du modele 'User'
     *
     * @var array[string]mixed
     */
    protected $attributes = [
        self::COL_EMAIL               => null,
        self::COL_EMAIL_VERIFIE_LE    => null,
        self::COL_HASH_PASSWORD       => null,
        self::COL_REMEMBER_TOKEN      => null,
        self::COL_POLY_MODELE_ID      => null,
        self::COL_POLY_MODELE_TYPE    => null,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::COL_EMAIL,
        self::COL_HASH_PASSWORD,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        self::COL_REMEMBER_TOKEN,
        self::COL_HASH_PASSWORD
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        self::COL_EMAIL_VERIFIE_LE => 'datetime',
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
    public function identite()
    {
        return $this->morphTo();
    }


    /* ====================================================================
     *                     INTERFACE 'AUTHENTIFICATION'
     * ====================================================================
     */
    /**
     * @return bool Renvoie TRUE si l'utilisateur est un enseignant, FALSE sinon.
     */
    public function estAdministrateur() : bool
    {
        $roleAdministrateur = Role::where(Role::COL_INTITULE, '=', Role::VAL_ADMIN)->first();
        return $this->roles->contains($roleAdministrateur);
    }

    /**
     * @return bool Renvoie TRUE si l'utilisateur est un enseignant, FALSE sinon.
     */
    public function estEnseignant() : bool
    {
        $roleEnseignant = Role::where(Role::COL_INTITULE, '=', Role::VAL_ENSEIGNANT)->first();
        return $this->roles->contains($roleEnseignant);
    }

    /**
     * @return bool Renvoie TRUE si l'utilisateur possede le role 'responsable_option', FALSE sinon.
     */
    public function estResponsableOption() : bool
    {
        $roleResponsableOption = Role::where(Role::COL_INTITULE, '=', Role::VAL_RESP_OPTION)->first();
        return $this->roles->contains($roleResponsableOption);
    }

    /**
     * @return bool Renvoie TRUE si l'utilisateur possede le role 'responsable_departement', FALSE sinon.
     */
    public function estResponsableDepartement() : bool
    {
        $roleResponsableDepartement = Role::where(Role::COL_INTITULE, '=', Role::VAL_RESP_DEPARTEMENT)->first();
        return $this->roles->contains($roleResponsableDepartement);
    }

    /**
     * @return bool Renvoie TRUE si l'utilisateur possede le role 'scolarite' et est membre de l'INSA
     */
    public function estScolariteINSA(): bool
    {
        $roleScolarite = Role::where(Role::COL_INTITULE, '=', Role::VAL_SCOLARITE)->first();
        return $this->roles->contains($roleScolarite);
    }
}
