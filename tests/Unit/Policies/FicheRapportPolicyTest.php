<?php

use App\Facade\UserFacade;
use App\Modeles\Enseignant;
use App\Modeles\Fiches\FicheRapport;
use Tests\TestCase;

class FicheRapportPolicyTest extends TestCase
{
    public function testShowAllow()
    {
        // Creation d'un enseignant ayant le droit
        $enseignant = factory(Enseignant::class)->create();
        $user       = UserFacade::creerDepuisEnseignant($enseignant->id, 'azerty');

        // Creation de la fiche de rapport
        $fiche = factory(FicheRapport::class)->create();

        // On donne le droit a l'utilisateur
        $fiche->stage->referent = $enseignant;
        $fiche->save();

        // Assertion
        $this->assertTrue($user->can('show', $fiche));
    }

    public function testShowDeny()
    {
        // Creation d'une fiche de rapport
        $fiche = factory(FicheRapport::class)->create();

        // Creation d'un utilisateur quelconque
        $enseignant = factory(Enseignant::class)->create();
        $user        = UserFacade::creerDepuisEnseignant($enseignant->id, 'azerty');

        // Assertion deny
        $this->assertFalse($user->can('show'), $fiche);
    }
}
