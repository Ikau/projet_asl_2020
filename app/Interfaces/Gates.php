<?php

namespace App\Interfaces;

/**
 * Il y a plusieurs de gerer le controle d'acces avec Laravel : Gates ou Policies.
 * Cette interface permet d'expliciter les differentes regles 'Gates'.
 *
 * En quelques mots, les 'Gates' sont des fonctions renvoyant TRUE ou FALSE pour indiquer une permission
 * sur une action ou une route. Les 'Gates' devraient etre utilisees pour des URL generalement.
 *
 * Plus d'infos sur la documentation de Laravel
 * [DOC] : https://laravel.com/docs/6.x/authorization#gates
 */
interface Gates
{
    /**
     * Enregistre toutes les regles 'Gates' relatives au controle d'acces des pages
     * pour le role 'adminitrateur'
     *
     * @return void
     */
    public function enregistrerGatesAdminitrateur();

    /**
     * Enregistre toutes les regles 'Gates' relatives au controle d'acces des pages
     * pour le role 'referent'
     *
     * @return void
     */
    public function enregistrerGatesReferent();

    /**
     * Enregistre toutes les regles 'Gates' relatives au controle d'acces des pages
     * pour le role 'responsable-option' ou 'responsable-departement'
     *
     * @return void
     */
    public function enregistrerGatesResponsable();

    /**
     * Enregistre toutes les regles 'Gates' relatives au controle d'acces des pages
     * pour le role 'scolarite'
     *
     * @return void
     */
    public function enregistrerGatesScolarite();
}
