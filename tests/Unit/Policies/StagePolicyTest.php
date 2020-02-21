<?php

namespace Tests\Unit\Policies;

use App\Facade\PermissionFacade;
use App\Facade\UserFacade;
use App\Modeles\Departement;
use App\Modeles\Enseignant;
use App\Modeles\Option;
use App\Modeles\Stage;
use Tests\TestCase;

class StagePolicyTest extends TestCase
{
    /**
     * @dataProvider validerAffectationProvider
     */
    public function testValiderAffectationAllow(bool $estOption, $division)
    {
        // Creation d'un stage
        $stage = factory(Stage::class)->create();

        // Creation d'un user enseignant lambda
        $enseignant = factory(Enseignant::class)->create();
        $user       = UserFacade::creerDepuisEnseignant($enseignant->id, 'azerty');

        // Pour valider une affectation : l'enseignant doit etre resp de l'option ou du departement du stage
        if($estOption)
        {
            PermissionFacade::remplaceResponsableOption($division->intitule, $enseignant);
            $stage->etudiant->option()->dissociate();
            $stage->etudiant->option()->associate($division);
            $stage->etudiant->save();

        }
        else
        {
            PermissionFacade::remplaceResponsableDepartement($division->intitule, $enseignant);
            $stage->etudiant->departement()->dissociate();
            $stage->etudiant->departement()->associate($division);
            $stage->etudiant->save();

        }

        $this->assertTrue($user->can('validerAffectation', $stage));
        $this->assertFalse($user->cant('validerAffectation', $stage));
    }

    /**
     * @dataProvider validerAffectationProvider
     */
    public function testValiderAffectationDeny(bool $estOption, $division)
    {
        // Creation d'un stage
        $stage = factory(Stage::class)->create();

        // Creation d'un user enseignant basique
        $enseignant = factory(Enseignant::class)->create();
        $enseignant->save();

        $user = UserFacade::creerDepuisEnseignant($enseignant->id, 'azerty');

        $this->assertTrue($user->cant('validerAffectation', $stage));
        $this->assertFalse($user->can('validerAffectation', $stage));
    }

    public function validerAffectationProvider()
    {
        // Pour l'utilisation de la BDD
        $this->refreshApplication();

        // Ensemble de tous les departements et toutes les options non nul
        $divisions = [];

        // Recuperation des donnees
        $departements = Departement::all();
        $options      = Option::all();

        // Creation de l'array
        foreach($options as $option)
        {
            $divisions[$option[Option::COL_INTITULE]] = [TRUE, $option];
        }
        foreach($departements as $departement)
        {
            $divisions[$departement[Departement::COL_INTITULE]] = [FALSE, $departement];
        }

        // [bool $estOption, Departement|Option $division]
        return $divisions;
    }
}
