<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Modeles\Entreprise;
use App\Http\Controllers\CRUD\EntrepriseController;
use App\Utils\Constantes;

class EntrepriseControllerTest extends TestCase
{
    // Rollback les modifications de la BDD a la fin des tests
    use RefreshDatabase;

    /* ====================================================================
     *                           TESTS AUXILIAIRES
     * ====================================================================
     */

    /**
     * @dataProvider normaliseInputsOptionnelsProvider
     */
    public function testNormaliseInputsOptionnels(string $clefModifiee, $nouvelleValeur)
    {
        $entreprise                = factory(Entreprise::class)->make();
        $entreprise['test']        = 'normaliseInputsOptionnels';
        $entreprise[$clefModifiee] = $nouvelleValeur;

        $response = $this->from(route('entreprises.index'))
        ->post(route('entreprises.tests'), $entreprise->toArray())
        ->assertRedirect('/');
    }
    
    public function normaliseInputsOptionnelsProvider()
    {
        // [string $clefModifiee, $nouvelleValeur]
        return [
            'Adresse2 null' => [Entreprise::COL_ADRESSE2, null],
            'CP null'       => [Entreprise::COL_CP, null],
            'Region null'   => [Entreprise::COL_REGION, null],

            'Adresse2 invalide' => [Entreprise::COL_ADRESSE2, -1],
            'CP invalide'       => [Entreprise::COL_CP, -1],
            'Region invalide'   => [Entreprise::COL_REGION, -1],
        ];
    }

    /**
     * @depends testNormaliseInputsOptionnels
     */
    public function testValiderForm()
    {
        $this->assertTrue(TRUE);
    }

    public function testValiderModele()
    {
        $this->assertTrue(TRUE);
    }

    /* ====================================================================
     *                           TESTS RESOURCES
     * ====================================================================
     */

    public function testIndex()
    {
        $this->assertTrue(TRUE);
    }

    public function testCreate()
    {
        $this->assertTrue(TRUE);
    }
    
    /**
     * @depends testValiderForm
     */
    public function testStore()
    {
        $this->assertTrue(TRUE);
    }

    /**
     * @depends testValiderModele
     */
    public function testShow()
    {
        $this->assertTrue(TRUE);
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     */
    public function testEdit()
    {
        $this->assertTrue(TRUE);
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     */
    public function testUpdate()
    {
        $this->assertTrue(TRUE);
    }

    /**
     * @depends testValiderModele
     */
    public function testDestroy()
    {
        $this->assertTrue(TRUE);
    }

    /* ====================================================================
     *                       FONCTIONS UTILITAIRES
     * ====================================================================
     */

    /**
     * Fonction auxiliaire facilitant la recuperation des attributs du modele a tester
     */
    private function getAttributsModele()
    {
        return Schema::getColumnListing(Entreprise::NOM_TABLE);
    }
}