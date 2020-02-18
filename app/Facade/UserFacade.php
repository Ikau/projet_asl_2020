<?php

namespace App\Facade;

use App\Interfaces\Authentification;
use App\Interfaces\User\ConstructeurUser;
use App\Modeles\Contact;
use App\Modeles\Enseignant;
use App\Modeles\Role;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserFacade implements Authentification, ConstructeurUser
{
    /* ====================================================================
     *                     INTERFACE 'AUTHENTIFICATION'
     * ====================================================================
     */
    /**
     * @return bool Renvoie TRUE si l'utilisateur est un enseignant, FALSE sinon.
     */
    public function estAdministrateur() : bool
    {
        $roleAdministrateur = Role::where(Role::COL_INTITULE, '=', Role::VAL_ADMIN)->first();
        return $this->roles->contains($roleAdministrateur);
    }

    /**
     * @return bool Renvoie TRUE si l'utilisateur est un enseignant, FALSE sinon.
     */
    public function estEnseignant() : bool
    {
        $roleEnseignant = Role::where(Role::COL_INTITULE, '=', Role::VAL_ENSEIGNANT)->first();
        return $this->roles->contains($roleEnseignant);
    }

    /**
     * @return bool Renvoie TRUE si l'utilisateur possede le role 'responsable_option', FALSE sinon.
     */
    public function estResponsableOption() : bool
    {
        $roleResponsableOption = Role::where(Role::COL_INTITULE, '=', Role::VAL_RESP_OPTION)->first();
        return $this->roles->contains($roleResponsableOption);
    }

    /**
     * @return bool Renvoie TRUE si l'utilisateur possede le role 'responsable_departement', FALSE sinon.
     */
    public function estResponsableDepartement() : bool
    {
        $roleResponsableDepartement = Role::where(Role::COL_INTITULE, '=', Role::VAL_RESP_DEPARTEMENT)->first();
        return $this->roles->contains($roleResponsableDepartement);
    }

    /**
     * @return bool Renvoie TRUE si l'utilisateur possede le role 'scolarite' et est membre de l'INSA
     */
    public function estScolariteINSA(): bool
    {
        $roleScolarite = Role::where(Role::COL_INTITULE, '=', Role::VAL_SCOLARITE)->first();
        return $this->roles->contains($roleScolarite);
    }

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
    public static function creerDepuisContact(int $id, string $motDePasse) : User
    {
        // Verification arg
        $contact = Contact::find($id);
        if(null === $contact
            || null === $motDePasse
            || ''   === trim($motDePasse))
        {
            return null;
        }

        // Verification unicite du lien
        $user = User::where([
            [User::COL_POLY_MODELE_TYPE, '=', Contact::class],
            [User::COL_POLY_MODELE_ID, '=', $id]
        ])->first();
        if( ! null === $user)
        {
            return $user;
        }

        // Creation du compte user
        $user = new User;
        $user->fill([
            User::COL_EMAIL         => $contact[Contact::COL_EMAIL],
            User::COL_HASH_PASSWORD => Hash::make($motDePasse)
        ]);
        $user->identite()->associate($contact);
        $user->save();

        return $user;
    }

    /**
     * Cree un compte user associe au modele Enseignant entre en argument
     *
     * @param  int $id L'ID de l'enseignant auquel lier ce compte
     *
     * @return Null|User Le compte user cree ou existant sinon null en cas d'erreur
     */
    public static function creerDepuisEnseignant(int $id, string $motDePasse) : User
    {
        // Verification args
        $enseignant = Enseignant::find($id);
        if(null === $enseignant
            || null === $motDePasse
            || ''   === trim($motDePasse))
        {
            return null;
        }

        // Verification unicite du lien
        $user = User::where([
            [User::COL_POLY_MODELE_TYPE, '=', Enseignant::class],
            [User::COL_POLY_MODELE_ID, '=', $id]
        ])->first();
        if( ! null === $user)
        {
            return $user;
        }

        // Creation de l'utilisateur
        $user = new User;
        $user->fill([
            User::COL_EMAIL         => $enseignant[Enseignant::COL_EMAIL],
            User::COL_HASH_PASSWORD => Hash::make($motDePasse)
        ]);
        $user->identite()->associate($enseignant);
        $user->save();

        return $user;
    }
}
