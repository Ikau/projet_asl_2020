<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Modeles\Enseignant;
use App\Http\Controllers\CRUD\EnseignantController;
use App\Utils\Constantes;

class EnseignantControllerTest extends TestCase
{
    // Rollback les modifications de la BDD a la fin des tests
    use RefreshDatabase;

    /**
     * Attributs sur lesquels effectuer les tests
     */
    private $attributs = [
        'nom',
        'prenom',
        'email',
        'responsable_option',
        'responsable_departement',
        'soutenances_candide',
        'soutenances_referent',
        'stages'
    ];

    /* ====================================================================
     *                           TESTS AUXILIAIRES
     * ====================================================================
     */

    public function testNormaliseOptionnels()
    {
        $this->assertTrue(TRUE);
    }

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
        $response = $this->get(route('enseignants.index'))
        ->assertOk()
        ->assertViewIs('enseignant.index')
        ->assertSee(EnseignantController::TITRE_INDEX);
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