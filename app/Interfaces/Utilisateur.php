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
     * @return App\TypeUser Renvoie une reference vers l'objet TypeUser auquel est rattache l'utilisateur
     */
    public function type();
}
