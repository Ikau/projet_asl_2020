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
     * Cree un compte user associe au modele Contact entre en argument
     * 
     * @param int    $id         L'ID du contact auquel lier ce compte
     * @param string $motDePasse Le mot de passe du compte user
     * 
     * @return Null|User Le compte user cree sinon null en cas d'erreur
     */
    static function fromContact(int $id, string $motDePasse) : User;

    /**
     * Cree un compte user associe au modele Enseignant entre en argument
     *
     * @param  int $id L'ID de l'enseignant auquel lier ce compte
     *
     * @return Null|User Le compte user cree sinon null en cas d'erreur
     */
    static function fromEnseignant(int $id, string $motDePasse) : User;

    /**
     * Renvoie le type de l'utilisateur.
     *
     * @return App\UserType Renvoie une reference vers l'objet UserType auquel est rattache l'utilisateur
     */
    public function type();

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
