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
        // Option
        if( (null !== $user->identite->responsable_option)
        && ($stage->etudiant->option->id === $user->identite->responsable_option->id) )
        {
            return true;
        }
        // Departement
        else if( (null !== $user->identite->responsable_departement)
        && ($stage->etudiant->departement->id === $user->identite->responsable_departement->id) )
        {
            return true;
        }
        return false;
    }
}
