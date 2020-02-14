<?php

use App\Modeles\Enseignant;
use App\Modeles\Fiches\FicheRapport;
use App\User;
use Tests\TestCase;

class FicheRapportPolicyTest extends TestCase
{
    public function testShowAllow()
    {
        // Creation d'un enseignant ayant le droit
        $enseignant = factory(Enseignant::class)->create();
        $user       = User::fromEnseignant($enseignant->id, 'azerty');

        // Creation de la fiche de rapport
        $fiche = factory(FicheRapport::class)->create();

        // On donne le droit a l'utilisateur
        $fiche->stage->referent = $enseignant;

        // Assertion
        $this->assertTrue($user->can('show', $fiche));
    }

    public function testShowDeny()
    {
        // Creation d'une fiche de rapport
        $fiche = factory(FicheRapport::class)->create();

        // Creation d'un utilisateur quelconque
        $enseignant = factory(Enseignant::class)->create();
        $user        = User::fromEnseignant($enseignant->id, 'azerty');

        // Assertion deny
        $this->assertFalse($user->can('show'), $fiche);
    }
}
