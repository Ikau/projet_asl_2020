<?php

namespace Tests\Unit\Modeles\Fiches;

use App\Facade\TestFacade;
use App\Http\Controllers\Enseignant\FicheRapportController;
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
    public function aaatestShow()
    {
        // Creation d'un enseignant valide
        $userEnseignant = $this->creerUserRoleEnseignant();

        // Creation d'une affectation valide
        $stage = TestFacade::creerStagePourEnseignant($userEnseignant);

        // Test routage
        $response =  $this->actingAs($userEnseignant)
            ->from('/')
            ->get(route('fiches.rapports.show', $stage->id))
            ->assertOk()
            ->assertViewIs('fiches.rapport.show')
            ->assertSee(FicheRapportController::VAL_TITRE_SHOW);

        // Integrite de l'entete
        $this->assertVoitEnteteFiches($response, $stage);

        // Integrite du contenu

    }

    /* ------------------------------------------------------------------
     *                  AUXILIAIRES : fonctions privees
     * ------------------------------------------------------------------
     */
    private function assertContenuFicheOk()
    {

    }
}
