<?php

namespace App\Policies;

use App\Modeles\Fiches\FicheRapport;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * Class FicheRapportPolicy
 *
 * Attention lorsque vous faites des policies : il PEUT y avoir interference entre ID contact et ID enseignant
 * Comparez plutot les emails : nous avon une contraite physique (base de donnees) qui permet de relier un utilisateur
 * a son identite !
 *
 * @package App\Policies
 */
class FicheRapportPolicy
{
    use HandlesAuthorization;

    /**
     * Indique si un compte utilisateur a le droit de voir une fiche de rapport
     *
     * @param User $user
     * @param FicheRapport $ficheRapport
     * @return bool
     */
    public function show(User $user, FicheRapport $ficheRapport)
    {
        return (
            ($user->email === $ficheRapport->stage->referent->email)
            || $user->estScolariteINSA()
        );
    }

    /**
     * Indique si un compte utilisateur a le droit de modifier une fiche de rapport
     *
     * @param User $user
     * @param FicheRapport $ficheRapport
     * @return bool
     */
    public function edit(User $user, FicheRapport $ficheRapport)
    {
        return $user->email === $ficheRapport->stage->referent->email;
    }
}
