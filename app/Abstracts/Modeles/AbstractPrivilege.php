<?php


namespace App\Abstracts\Modeles;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractPrivilege extends Model
{

    /**
     * Fonction auxiliaire permettant d'avoir une liste des intitules possibles
     * 
     * @return array(string)
     */
    abstract public static function getIntitules();

    /**
     * Renvoie la liste des utilisateurs ayant le privilege associe
     *
     * @return App\User
     */
    abstract public function users();

    /**
     * Renvoie la liste des roles ayant le privilege associe
     * 
     * @return App\Modeles\Role
     */
    abstract public function roles();
}
