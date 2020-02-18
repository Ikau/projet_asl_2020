<?php

namespace App\Interfaces;

use App\User;
use App\Modeles\Contact;
use App\Modeles\Enseignant;

/**
 * Le choix arbitraire d'utiliser le modele 'User' par defaut de Laravel
 * rend la comprehension du code moins evidente.
 *
 * Cette interface sert donc pour savoir quelles methodes ont ete ajoutees
 * par rapport au modele par defaut.
 */
interface Utilisateur
{
    /**
     * Renvoie les privileges de l'utilisateur.
     *
     * @return array[App\Modeles\Privilege] Array de tous les privileges de l'utilisateur.
     */
    public function privileges();

    /**
     * Renvoie les roles de l'utilisateur.
     *
     * @return Collection[app\Modeles\Role]
     */
    public function roles();

    /**
     * Renvoie le modele associe au compte utilisateur.abnf
     *
     * C'est une relation One-to-One polymorphique qui peut renvoyer :
     *  - un enseignant
     *  - un contact
     * Peut etre etendu a un etudiant si besoin
     * [DOC] : https://laravel.com/docs/6.x/eloquent-relationships#one-to-one-polymorphic-relations
     *
     * @return App\Modeles\Contact|App\Modeles\Enseignant
     */
    public function identite();
}
