<?php

namespace App\Policies;

use App\Modeles\Fiches\FicheRapport;
use App\User;

class FicheRapportPolicy
{
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
