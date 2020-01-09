<?php 

namespace App;


use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractUserType;
use App\Utils\Constantes;
use App\User;

class UserType extends AbstractUserType
{
    /*
     * Nom des colonnes dans la table du modele 
     */
    const COL_INTITULE = 'intitule';

    /**
     * @var string Nom de la table associee au modele 'UserType'
     */
    const NOM_TABLE = 'usertypes';

    /*
     * On demande specifiquement a Laravel d'utiliser ce nom pour la table
     */
    protected $table = UserType::NOM_TABLE;

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'
     * 
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * Valeurs par defaut des colonnes du modele 'UserType'
     * 
     * @var array[string]mixed
     */
    protected $attributs = [
        UserType::COL_INTITULE => Constantes::STRING_VIDE
    ];

    /**
     * Renvoie les utilisateurs rattache au type specifie
     *
     * @return void
     */
    public function users()
    {
        return $this->hasMany('App\User', User::COL_TYPE_ID);
    }
}