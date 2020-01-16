<?php


namespace App\Abstracts\Modeles;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractRole extends Model
{

    /**
     * Fonction auxiliaire permettant d'avoir une liste des intitules possibles
     * 
     * @return array(string)
     */
    abstract public static function getIntitules();

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
