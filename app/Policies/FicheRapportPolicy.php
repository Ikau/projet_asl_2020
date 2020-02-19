<?php

namespace App\Policies;

use App\Modeles\Fiches\FicheRapport;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

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
            ($user->identite->id === $ficheRapport->stage->referent->id)
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
        return $user->identite->id === $ficheRapport->stage->referent->id;
    }
}
