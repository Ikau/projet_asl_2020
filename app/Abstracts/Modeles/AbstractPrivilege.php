<?php


namespace App\Abstracts\Modeles;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractPrivilege extends Model
{
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
