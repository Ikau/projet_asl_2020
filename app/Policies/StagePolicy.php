<?php

namespace App\Policies;

use App\Modeles\Departement;
use App\Modeles\Enseignant;
use App\Modeles\Option;
use App\Modeles\Stage;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class StagePolicy
{
    use HandlesAuthorization;

    /**
     * Indique si l'utilisateur courant a le droit de valider l'affectation de stage ou non
     *
     * @param User $user
     * @param Stage $stage
     * @return bool
     */
    public function validerAffectation(User $user, Stage $stage)
    {
        if(null !== $user->identite[Enseignant::COL_RESPONSABLE_OPTION_ID]
        && $stage->etudiant->option->id === $user->identite[Enseignant::COL_RESPONSABLE_OPTION_ID])
        {
            return true;
        }
        else if(null !== $user->identite[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID]
        && $stage->etudiant->departement->id === $user->identite[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID])
        {
            return true;
        }
        return false;
    }
}
