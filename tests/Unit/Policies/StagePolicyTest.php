<?php

namespace Tests\Unit\Policies;

use App\Modeles\Departement;
use App\Modeles\Enseignant;
use App\Modeles\Etudiant;
use App\Modeles\Option;
use App\Modeles\Stage;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StagePolicyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @dataProvider validerProvider
     */
    public function testValiderAllow(bool $estOption, $idDivision)
    {
        // Creation d'un stage
        $stage = factory(Stage::class)->create();

        // Creation d'un user enseignant lambda
        $enseignant = factory(Enseignant::class)->create();
        $user       = User::fromEnseignant($enseignant->id, 'azerty');

        // On les attache au stage
        if($estOption)
        {
            $stage->etudiant->option->id = $idDivision;
            $user->identite[Enseignant::COL_RESPONSABLE_OPTION_ID]   = $idDivision;

        }
        else
        {
            $stage->etudiant->departement->id = $idDivision;
            $user->identite[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID]   = $idDivision;
        }

        $stage->etudiant->save();
        $enseignant->save();
        $user->save();

        $this->assertTrue($user->can('valider', $stage));
        $this->assertFalse($user->cant('valider', $stage));
    }

    /**
     * @dataProvider validerProvider
     */
    public function testValiderDeny(bool $estOption, $idDivision)
    {
        // Creation d'un stage
        $stage = factory(Stage::class)->create();

        // Recuperation des ID nul
        $idOptionNul      = Option::where(Option::COL_INTITULE, '=', Option::VAL_AUCUN)->first()->id;
        $idDepartementNul = Departement::where(Departement::COL_INTITULE, '=', Departement::VAL_AUCUN)->first()->id;

        // Creation d'un user enseignant basique
        $enseignant = factory(Enseignant::class)->create();
        $enseignant[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID] = $idOptionNul;
        $enseignant[Enseignant::COL_RESPONSABLE_OPTION_ID]      = $idDepartementNul;
        $enseignant->save();

        $user = User::fromEnseignant($enseignant->id, 'azerty');

        $this->assertTrue($user->cant('valider', $stage));
        $this->assertFalse($user->can('valider', $stage));
    }

    public function validerProvider()
    {
        // Pour l'utilisation de la BDD
        $this->refreshApplication();

        // Ensemble de tous les departements et toutes les options non nul
        $divisions = [];

        // Recuperation des donnees
        $departements = Departement::where(Departement::COL_INTITULE, '<>', Departement::VAL_AUCUN)->get();
        $options      = Option::where(Option::COL_INTITULE, '<>', Option::VAL_AUCUN)->get();

        // Creation de l'array
        foreach($options as $option)
        {
            $divisions[$option->intitule] = [TRUE, $option->id];
        }
        foreach($departements as $departement)
        {
            $divisions[$departement->intitule] = [FALSE, $departement->id];
        }

        // [bool $estOption, $iddivision
        return $divisions;
    }
}
