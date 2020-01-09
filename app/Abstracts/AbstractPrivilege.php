<?php


namespace App\Abstracts;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractPrivilege extends Model
{
    /**
     * Renvoie la liste des utilisateurs ayant le privilege associe
     *
     * @return App\User
     */
    abstract public function users();
}
