<?php

namespace App\Interfaces\User;

use App\User;

interface ConstructeurUser
{

    /**
     * Cree un compte user associe au modele Contact entre en argument
     *
     * @param int    $id         L'ID du contact auquel lier ce compte
     * @param string $motDePasse Le mot de passe du compte user
     *
     * @return Null|User Le compte user cree sinon null en cas d'erreur
     */
    static function creerDepuisContact(int $id, string $motDePasse) : User;

    /**
     * Cree un compte user associe au modele Enseignant entre en argument
     *
     * @param  int $id L'ID de l'enseignant auquel lier ce compte
     *
     * @return Null|User Le compte user cree sinon null en cas d'erreur
     */
    static function creerDepuisEnseignant(int $id, string $motDePasse) : User;
}
