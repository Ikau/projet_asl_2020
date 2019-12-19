<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Modeles\Stage;
use App\Http\Controllers\CRUD\StageController;
use App\Utils\Constantes;

class StageControllerTest extends TestCase
{
    // Rollback les modifications de la BDD a la fin des tests
    use RefreshDatabase;

    /**
     * Fonction pour recuperer les attributs sur lesquels effectuer les tests
     * 
     * Schema::getColumnListing(Template::NOM_TABLE);
     */

    /* ====================================================================
     *                           TESTS AUXILIAIRES
     * ====================================================================
     */

     /**
      * @dataProvider normaliseOptionnelsProvider
      */
    public function testNormaliseOptionnels(string $clefModifiee, $nouvelleValeur)
    {
        $stage                = factory(Stage::class)->make();
        $stage['test']        = 'normaliseInputsOptionnels';
        $stage[$clefModifiee] = $nouvelleValeur;

        $response = $this->followingRedirects()
        ->from(route('stages.tests'))
        ->post(route('stages.tests'), $stage->toArray())
        ->assertOk();
    }

    public function normaliseOptionnelsProvider()
    {
        // [string $clefModifiee, $nouvelleValeur]
        return [
            'Convention envoyee valide' => [Stage::COL_CONVENTION_ENVOYEE, FALSE],
            'Convention signee valide'  => [Stage::COL_CONVENTION_SIGNEE, FALSE],
            'Moyen de recherche valide' => [Stage::COL_MOYEN_RECHERCHE, 'valide'],

            'Convention envoyee null' => [Stage::COL_CONVENTION_ENVOYEE, null],
            'Convention signee null'  => [Stage::COL_CONVENTION_SIGNEE, null],
            'Moyen de recherche null' => [Stage::COL_MOYEN_RECHERCHE, null],

            'Convention envoyee invalide' => [Stage::COL_CONVENTION_ENVOYEE, 'invalide'],
            'Convention signee invalide'  => [Stage::COL_CONVENTION_SIGNEE, 'invalide'],
            'Moyen de recherche invalide' => [Stage::COL_MOYEN_RECHERCHE, -1],
        ];
    }

    /**
     * @depends testNormaliseOptionnels
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
}