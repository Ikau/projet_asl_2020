<?php

namespace Tests\Unit\Modeles\Fiches;

use App\Facade\TestFacade;
use App\Http\Controllers\Fiches\FicheRapportController;
use App\Modeles\Fiches\FicheRapport;
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
     *           AUXILIAIRES : tests de controle d'acces
     * ------------------------------------------------------------------
     */
    /**
     * @dataProvider normaliseOptionnelsProvider
     * @param string $clefModifiee
     * @param $nouvelleValeur
     */
    public function testNormaliseOptionnels(string $clefModifiee, $nouvelleValeur)
    {
        $fiche                = factory(FicheRapport::class)->make();
        $fiche['test']        = 'normaliseInputsOptionnels';
        $fiche[$clefModifiee] = $nouvelleValeur;

        $this->from(route('fiches.rapport.tests'))
            ->post(route('fiches.rapport.tests'), $fiche->toArray())
            ->assertRedirect('/');
    }

    public function normaliseOptionnelsProvider()
    {
        return [
            'Appreciation valide' => [FicheRapport::COL_APPRECIATION, 'valide'],
            'Contenu valide'      => [FicheRapport::COL_CONTENU, []],

            'Appreciation null'   => [FicheRapport::COL_APPRECIATION, null],
            'Contenu null'        => [FicheRapport::COL_CONTENU, null],

            'Appreciation invalide' => [FicheRapport::COL_APPRECIATION, -1],
            'Contenu invalide'      => [FicheRapport::COL_CONTENU, -1]
        ];
    }

    /**
     * @depends testNormaliseOptionnels
     * @dataProvider validerFormProvider
     */
    public function testValiderForm(bool $possedeErreur, string $clefModifie, $nouvelleValeur)
    {
        $fiche               = factory(FicheRapport::class)->create();
        $fiche['test']       = 'validerForm';
        $fiche[$clefModifie] = $nouvelleValeur;

        $routeSource = route('fiches.rapport.tests');
        $response = $this->from($routeSource)
            ->post(route('fiches.rapport.tests'), $fiche->toArray());

        if($possedeErreur)
        {
            $response->assertSessionHasErrors($clefModifie)
                ->assertRedirect($routeSource);
        }
        else
        {
            $response->assertSessionDoesntHaveErrors()
                ->assertRedirect('/');
        }
    }

    public function validerFormProvider()
    {
        //bool $possedeErreur, string $clefModifie, $nouvelleValeur
        return [
            // Sucess
            'Appreciation valide' => [FALSE, FicheRapport::COL_APPRECIATION, 'valide'],
            'Contenu valide'      => [FALSE, FicheRapport::COL_CONTENU, [[0, 1, 2], [0, 1, 2, 3], [0, 1]]],
            'Stage valide'        => [FALSE, 'valide', 'dansFactory'],
            'Modele valide'       => [FALSE, 'valide', 'dansFactory'],


            'Appreciation null' => [FALSE, FicheRapport::COL_APPRECIATION, null],
            'Contenu null'      => [FALSE, FicheRapport::COL_CONTENU, null],

            'Appreciation invalide' => [FALSE, FicheRapport::COL_APPRECIATION, -1],
            'Contenu invalide'      => [FALSE, FicheRapport::COL_CONTENU, -1],

            // Echecs
            'Stage null'  => [TRUE, FicheRapport::COL_STAGE_ID, null],
            'Modele null' => [TRUE, FicheRapport::COL_MODELE_ID, null],

            'Stage invalide'  => [TRUE, FicheRapport::COL_STAGE_ID, -1],
            'Modele invalide' => [TRUE, FicheRapport::COL_MODELE_ID, -1],
        ];
    }

    /**
     * @dataProvider validerModeleProvider
     */
    public function testValiderModele(int $idCase, int $statutAttendu)
    {
        $fiche = factory(FicheRapport::class)->create();
        $id = null;
        switch($idCase)
        {
            case 0:
                $id = $fiche->id;
                break;

            case 1:
                $id = "$fiche->id";
                break;

            case 2:
                $id = -1;
                break;

            case 3:
                $id = null;
                break;
        }

        $response = $this->followingRedirects()
            ->from(route('fiches.rapport.tests'))
            ->post(route('fiches.rapport.tests'), [
                'test' => 'validerModele',
                'id'   => $id
            ])
            ->assertStatus($statutAttendu);
    }

    public function validerModeleProvider()
    {
        // [int $idCas, int $statutAttendu]
        return [
            // Succes
            'Id valide'    => [0, 200],
            'Id numerique' => [1, 200],

            // Echecs
            'Id invalide'  => [2, 404],
            'Id null'      => [3, 404],
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
            ->get(route('fiches.rapport.show', $stage->fiche_rapport->id))
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
            ->get(route('fiches.rapport.edit', $stage->fiche_rapport->id))
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
