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

    public function valider(User $user, Stage $stage)
    {
        // Recuperation des ID nul
        $idOptionNul      = Option::where(Option::COL_INTITULE, '=', Option::VAL_AUCUN)->first()->id;
        $idDepartementNul = Departement::where(Departement::COL_INTITULE, '=', Departement::VAL_AUCUN)->first()->id;

        if($idOptionNul !== $user->identite[Enseignant::COL_RESPONSABLE_OPTION_ID]
        && $stage->etudiant->option->id === $user->identite[Enseignant::COL_RESPONSABLE_OPTION_ID])
        {
            return true;
        }
        else if($idDepartementNul !== $user->identite[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID]
        && $stage->etudiant->departement->id === $user->identite[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID])
        {
            return true;
        }
        return false;
    }
}
