<?php


namespace App\Abstracts\Modeles;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractPrivilege extends Model
{
    /**
     * Renvoie la liste des utilisateurs ayant ce role
     *
     * @return App\User
     */
    abstract public function users();

    /**
     * Renvoie la liste des privileges donnes a ce role
     *
     * @return App\Modeles\Privilege
     */
    abstract public function privileges();
}
