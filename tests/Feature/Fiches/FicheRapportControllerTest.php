<?php

namespace Tests\Unit\Modeles\Fiches;

use App\Facade\TestFacade;
use App\Http\Controllers\Fiches\FicheRapportController;
use App\Traits\TestFiches;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Traits\TestAuthentification;
use Tests\TestCase;


class FicheRapportControllerTest extends TestCase
{
    use RefreshDatabase, TestAuthentification, TestFiches;

    /* ------------------------------------------------------------------
     *           AUXILIAIRES : tests de controle d'acces
     * ------------------------------------------------------------------
     */
    /**
     * Permet de facilement tester les differentes routes
     */
    public function controleAccesProvider()
    {
        // [string $route]
        return [
            'Index'            => ['referents.index'],
            'Mes affectations' => ['referents.affectations'],
        ];
    }

    /* ------------------------------------------------------------------
     *                        Tests des routes
     * ------------------------------------------------------------------
     */
    public function testShow()
    {
        // Creation d'un enseignant valide
        $userEnseignant = $this->creerUserRoleEnseignant();

        // Creation d'une affectation valide
        $stage = TestFacade::creerStagePourEnseignant($userEnseignant);

        // Test routage
        $response =  $this->actingAs($userEnseignant)
            ->from('/')
            ->get(route('fiches.rapport.show', $stage->id))
            ->assertOk()
            ->assertViewIs('fiches.rapport.show')
            ->assertSee(FicheRapportController::VAL_TITRE_SHOW);

        // Integrite de l'entete
        $this->assertVoitEnteteFiches($response, $stage);

        // Integrite des sections
        $this->assertSectionsEtCriteresIntegres($response, $stage->fiche_rapport->modele->sections);
    }

    public function testEdit()
    {
        // Creation d'un enseignant valide
        $userEnseignant = $this->creerUserRoleEnseignant();

        // Creation d'une affectation valide
        $stage = TestFacade::creerStagePourEnseignant($userEnseignant);

        // Routage
        $response = $this->actingAs($userEnseignant)
            ->from('/')
            ->get(route('fiches.rapport.edit', $stage->id))
            ->assertOk()
            ->assertViewIs('fiches.rapport.form')
            ->assertSee(FicheRapportController::VAL_TITRE_EDIT);

        // Integrite de l'entete
        $this->assertVoitEnteteFiches($response, $stage);

        // Integrite des sections
        $this->assertSectionsEtCriteresIntegres($response, $stage->fiche_rapport->modele->sections);
    }

    /*
    public function testStore()
    {
        // Creation d'un enseignant valide
        $userEnseignant = $this->creerUserRoleEnseignant();

        // Creation d'une affectation valide
        $stage = TestFacade::creerStagePourEnseignant($userEnseignant);

        // Test routage
        $response = $this->actingAs($userEnseignant)
            ->from(route('fiches'))
    }
    */

    /* ------------------------------------------------------------------
     *                  AUXILIAIRES : fonctions privees
     * ------------------------------------------------------------------
     */
    private function assertContenuFicheOk()
    {

    }
}
