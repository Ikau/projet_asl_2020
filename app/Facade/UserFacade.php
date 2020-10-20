<?php

namespace App\Facade;

use App\Interfaces\User\ConstructeurUser;
use App\Modeles\Contact;
use App\Modeles\Enseignant;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class UserFacade implements ConstructeurUser
{
    /* ====================================================================
     *                    INTERFACE 'CONSTRUCTEUR_USER'
     * ====================================================================
     */
    /**
     * Cree un compte user associe au modele Contact entre en argument
     *
     * @param int    $id         L'ID du contact auquel lier ce compte
     * @param string $motDePasse Le mot de passe du compte user
     *
     * @return Null|User Le compte user cree ou existant sinon null en cas d'erreur
     */
    public static function creerDepuisContact(int $id, string $motDePasse) : ?User
    {
        // Verification arg
        $contact = Contact::find($id);
        if(null === $contact
            || null === $motDePasse
            || ''   === trim($motDePasse))
        {
            return null;
        }

        return self::creerUser($contact, $motDePasse);
    }

    /**
     * Cree un compte user associe au modele Enseignant entre en argument
     *
     * @param  int $id L'ID de l'enseignant auquel lier ce compte
     *
     * @return Null|User Le compte user cree ou existant sinon null en cas d'erreur
     */
    public static function creerDepuisEnseignant(int $id, string $motDePasse) : ?User
    {
        // Verification args
        $enseignant = Enseignant::find($id);
        if(null === $enseignant
            || null === $motDePasse
            || ''   === trim($motDePasse))
        {
            return null;
        }

        return self::creerUser($enseignant, $motDePasse);
    }

    /* ====================================================================
     *                         FONCTIONS PRIVEES
     * ====================================================================
     */
    private static function creerUser(Model $modele, string $motDePasse) : User
    {
        // Verification unicite du lien
        $user = User::where([
            [User::COL_POLY_MODELE_TYPE, '=', Enseignant::class],
            [User::COL_POLY_MODELE_ID, '=', $modele->id]
        ])->first();
        if( ! null === $user)
        {
            return $user;
        }

        // Creation de l'utilisateur
        $user = new User;
        $user->fill([
            User::COL_EMAIL         => $modele->email,
            User::COL_HASH_PASSWORD => Hash::make($motDePasse)
        ]);
        $user->identite()->associate($modele);
        $user->save();

        return $user;
    }
}
