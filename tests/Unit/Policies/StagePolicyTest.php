<?php

namespace Tests\Unit\Policies;

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
    public function testValiderAffectationAllow(bool $estOption, $idDivision)
    {
        // Creation d'un stage
        $stage = factory(Stage::class)->create();

        // Creation d'un user enseignant lambda
        $enseignant = factory(Enseignant::class)->create();
        $user       = UserFacade::creerDepuisEnseignant($enseignant->id, 'azerty');

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

        // Sauvegarde des changements
        $stage->etudiant->save();
        $enseignant->save();
        $user->save();

        $this->assertTrue($user->can('validerAffectation', $stage));
        $this->assertFalse($user->cant('validerAffectation', $stage));
    }

    /**
     * @dataProvider validerAffectationProvider
     */
    public function testValiderAffectationDeny(bool $estOption, $idDivision)
    {
        // Creation d'un stage
        $stage = factory(Stage::class)->create();

        // Creation d'un user enseignant basique
        $enseignant = factory(Enseignant::class)->create();
        $enseignant[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID] = null;
        $enseignant[Enseignant::COL_RESPONSABLE_OPTION_ID]      = null;
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
        $options      = Departement::all();

        // Creation de l'array
        foreach($options as $option)
        {
            $divisions[$option->intitule] = [TRUE, $option->id];
        }
        foreach($departements as $departement)
        {
            $divisions[$departement->intitule] = [FALSE, $departement->id];
        }

        // [bool $estOption, $iddivision]
        return $divisions;
    }
}
