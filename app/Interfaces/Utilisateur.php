<?php 

namespace App\Interfaces;

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
     * Renvoie le type de l'utilisateur.
     *
     * @return App\UserType Renvoie une reference vers l'objet UserType auquel est rattache l'utilisateur
     */
    public function type();

    /**
     * Renvoie les privileges de l'utilisateur.
     * 
     * @return array[App\Modeles\Privileges] Array de tous les privileges de l'utilisateur.
     */
    public function privileges();
}
