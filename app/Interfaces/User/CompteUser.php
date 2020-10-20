<?php

namespace App\Interfaces;

/**
 * Le choix a ete fait de lier chaque utilisateur a une identitee dans la base de donnees;
 *
 * Un utilisateur est donc associe a un modele Enseignant ou Contact.
 * L'inverse est obligatoire pour l'enseignant mais pas pour le contact.
 *
 * On recupere le compte User (le cas echeant) selon un One-to-One polymorphique.
 * L'utilisation de cette interface permet donc d'etre sur que la classe implemente cette relation.
 * [DOC] : https://laravel.com/docs/6.x/eloquent-relationships#one-to-one-polymorphic-relations
 */
interface CompteUser
{
    /**
     * Renvoie le compte User associe au modele implementant l'interface le cas echeant.
     *
     * @return App\User
     */
    public function user();
}
