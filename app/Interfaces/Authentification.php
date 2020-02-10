<?php 


namespace App\Interfaces;


/**
 * Interface utilisee pour les fonctions relatif au controle d'acces et l'authentification. 
 * 
 * Elle propose a la classe qui l'implémente de mettre a disposition des methodes pour justifier
 * son role, ses privileges.
 * 
 * Pour l'instant, cette interface n'est utilisee que par la class App\User car c'est la seule
 * qui prend en charge la notion de connexion et de compte utilisateur.
 */
interface Authentification
{
    /**
     * @return bool Renvoie TRUE si l'utilisateur est un enseignant, FALSE sinon.
     */
    public function estEnseignant() : bool;

    /**
     * @return bool Renvoie TRUE si l'utilisateur possede le role 'responsable_option', FALSE sinon.
     */
    public function estResponsableOption() : bool;

    /**
     * @return bool Renvoie TRUE si l'utilisateur possede le role 'responsable_departement', FALSE sinon.
     */
    public function estResponsableDepartement() : bool;
}
