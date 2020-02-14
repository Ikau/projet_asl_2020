<?php

namespace App\Policies;

use App\Modeles\Fiches\FicheRapport;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FicheRapportPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param FicheRapport $ficheRapport
     * @return bool
     */
    public function show(User $user, FicheRapport $ficheRapport)
    {
        return $user->identite->id === $ficheRapport->stage->referent->id;
    }
}
