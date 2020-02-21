<?php

namespace App\Interfaces\Permissions;

use App\User;

/**
 * Interface fournissant toutes les fonctions pour gerer les roles des utilisateurs.
 *
 * @package App\Interfaces
 */
interface GestionRoles
{
    /**
     * Ajoute le role entre en argument au compte utilisateur donne
     *
     * @param string $intituleRole
     * @param User $user
     * @return bool TRUE si succes, FALSE sinon
     */
    public static function ajouterRole(string $intituleRole, User $user) : bool;
}
