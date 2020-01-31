<?php

namespace Tests;

use App\Modeles\Enseignant;
use App\Modeles\Role;

use App\User;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    /* ====================================================================
     *                          FONCTIONS PRIVEES
     * ====================================================================
     */

    /**
     * Fonction auxiliaire permettant de creer un compte user avec le role 'enseignant'
     * Le compte user est lie a un compte enseignant valide
     * 
     * @return App\User
     */
    function creerUserRoleEnseignant()
    {
        // Creation d'un enseignant permis
        $enseignant = factory(Enseignant::class)->create();
        
        // Creation de l'utilisteur associe
        $user = User::fromEnseignant($enseignant->id, 'azerty');
        
        // Ajout du role 'referent'
        $roleEnseignant = Role::where(Role::COL_INTITULE, '=', Role::VAL_ENSEIGNANT)->first();
        $user->roles()->attach($roleEnseignant);
        $user->save();

        return $user;
    }

    /**
     * Ajoute le role 'responsable_option' a l'utilisateur entre en argument
     */
    function ajouteRoleResponsableDepartement(User $user)
    {
        // Recuperation du role 'responsable_departement'
        $roleResponsableDepartement = Role::where(Role::COL_INTITULE, '=', Role::VAL_RESP_DEPARTEMENT)->first();

        // Ajout du role a l'utilisateur
        $user->roles()->attach($roleResponsableDepartement);
        $user->save();
    }
}
