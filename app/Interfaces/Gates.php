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
     * Enregistre toutes les regles 'Gates' relatifs au controle d'acces pour l'espace.
     *
     * @return void 
     */
    public function enregistrerGatesReferent();
}