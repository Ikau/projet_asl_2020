<?php

namespace App\Facade;

use App\Interfaces\Permissions\GestionRoles;
use App\Interfaces\Permissions\GestionResponsable;
use App\Modeles\Departement;
use App\Modeles\Enseignant;
use App\Modeles\Option;
use App\Modeles\Role;
use App\User;

/**
 * Facade servant pour l'instant a gerer les roles des differents utilisateurs.
 *
 * @package App\Facade
 */
class PermissionFacade implements GestionResponsable, GestionRoles
{

    /* ====================================================================
     *                 INTERFACE 'GestionResponsable'
     * ====================================================================
     */
    /**
     * @inheritDoc
     */
    public static function remplaceResponsableDepartement(string $intituleDepartement, Enseignant $enseignant) : bool
    {
        if(null === $enseignant)
        {
            return false;
        }

        $departement = Departement::where(Departement::COL_INTITULE, '=', $intituleDepartement)->first();
        if(null === $departement)
        {
            return false;
        }

        // Mise a jour de la relation belongsTo
        $departement->responsable()->dissociate();
        $departement->responsable()->associate($enseignant->id);
        $departement->save();
        return true;
    }

    /**
     * @inheritDoc
     */
    public static function remplaceResponsableOption(string $intituleOption, Enseignant $enseignant) : bool
    {
        if(null === $enseignant)
        {
            return false;
        }

        $option = Option::where(Option::COL_INTITULE, '=', $intituleOption)->first();
        if(null === $option)
        {
            return false;
        }

        // Mise a jour de la relation belongsTo
        $option->responsable()->dissociate();
        $option->responsable()->associate($enseignant->id);
        $option->save();
        return true;
    }

    /**
     * @inheritDoc
     */
    public static function supprimeResponsableDepartement(string $intituleDepartement): bool
    {
        $departement = Departement::where(Departement::COL_INTITULE, '=', $intituleDepartement)->first();
        if(null === $departement)
        {
            return false;
        }

        $departement->responsable()->dissociate();
        $departement->save();
        return true;
    }

    /**
     * @inheritDoc
     */
    public static function supprimeResponsableOption(string $intituleOption): bool
    {
        $option = Option::where(Option::COL_INTITULE, '=', $intituleOption)->first();
        if(null === $option)
        {
            return false;
        }

        $option->responsable()->dissociate();
        $option->save();
        return true;
    }

    /* ====================================================================
     *                     INTERFACE 'GestionRoles'
     * ====================================================================
     */
    /**
     * @inheritDoc
     */
    public static function ajouterRole(string $intituleRole, User $user) : bool
    {
        if(null === $user)
        {
            return false;
        }

        $role = Role::where(Role::COL_INTITULE, '=', $intituleRole)->first();
        if(null === $role)
        {
            return false;
        }

        // Mise a jour de la relation belongsTo
        $user->roles()->attach($role);
        return true;
    }
}
