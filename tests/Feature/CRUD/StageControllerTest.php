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

    public function testNormaliseOptionnels()
    {
        $this->assertTrue(TRUE);
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