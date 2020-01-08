<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;


    /*
     * Nom des colonnes dans la base de donnees
     */
    const COL_EMAIL            = 'email';
    const COL_EMAIL_VERIFIE_LE = 'email_verified_at';
    const COL_HASH_PASSWORD    = 'password';
    const COL_REMEMBER_TOKEN   = 'remember_token';

    /**
     * @var string Nom de la table associee au model 'User'.
     */
    const NOM_TABLE = 'users';

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
}
