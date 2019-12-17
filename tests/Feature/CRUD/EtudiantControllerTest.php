<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Modeles\Etudiant;
use App\Http\Controllers\CRUD\EtudiantController;
use App\Utils\Constantes;

class EtudiantControllerTest extends TestCase
{
    // Rollback les modifications de la BDD a la fin des tests
    use RefreshDatabase;

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
        $response = $this->get(route('etudiants.index'))
        ->assertOK()
        ->assertViewIs('etudiant.index')
        ->assertSee(EtudiantController::TITRE_INDEX);

        foreach(Schema::getColumnListing(Etudiant::NOM_TABLE) as $attribut)
        {
            $response->assertSee("<td>$attribut</td>");
        }
    }

    public function testCreate()
    {
        $response = $this->get(route('etudiants.create'))
        ->assertOK()
        ->assertViewIs('etudiant.form')
        ->assertSee(EtudiantController::TITRE_CREATE);

        foreach(Schema::getColumnListing(Etudiant::NOM_TABLE) as $attribut)
        {
            if($attribut !== 'id') $response->assertSee("name=\"$attribut\"");
        }
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