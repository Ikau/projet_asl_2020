<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use App\Interfaces\Utilisateur;

class User extends Authenticatable implements Utilisateur
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
    const COL_EMAIL_VERIFIE_LE = 'email_verified_at';
    const COL_HASH_PASSWORD    = 'password';
    const COL_REMEMBER_TOKEN   = 'remember_token';

    /*
     * Nom des colonnes des clefs etrangeres 
     */
    const COL_TYPE_ID     = 'usertype_id';
    const COL_IDENTITE_ID = 'identite_id';

    /*
     * Nom de la table de jointure pour une relation Mane-to-Many 
     */
    const NOM_TABLE_PRIVILEGE_USER = 'privilege_user';

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
        User::COL_TYPE_ID,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        User::COL_HASH_PASSWORD, 
        User::COL_REMEMBER_TOKEN,
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
        return $this->belongsToMany('App\Modeles\Privilege', User::NOM_TABLE_PRIVILEGE_USER);
    }
}
