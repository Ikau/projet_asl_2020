<?php 

namespace App;


use Illuminate\Database\Eloquent\Model;

use App\Abstracts\AbstractTypeUser;
use App\Utils\Constantes;
use App\User;

class TypeUser extends AbstractTypeUser
{
    /*
     * Nom des colonnes dans la table du modele 
     */
    const COL_INTITULE = 'intitule';

    /**
     * @var string Nom de la table associee au modele 'TypeUser'
     */
    const NOM_TABLE = 'types_user';

    /*
     * On demande specifiquement a Laravel d'utiliser ce nom pour la table
     */
    protected $table = TypeUser::NOM_TABLE;

    /**
     * Indique a Laravel de ne pas creer ni de gerer les tables 'created_at' et 'updated_at'
     * 
     * @var bool Gestion des timestamps
     */
    public $timestamps = false;

    /**
     * Valeurs par defaut des colonnes du modele 'TypeUser'
     * 
     * @var array[string]mixed
     */
    protected $attributs = [
        TypeUser::COL_INTITULE => Constantes::STRING_VIDE
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