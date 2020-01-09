<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Modeles\Privilege;
use App\Http\Controllers\CRUD\PrivilegeController;
use App\Utils\Constantes;

class PrivilegeControllerTest extends TestCase
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
        $privilege                = factory(Privilege::class)->make();
        $privilege['test']        = 'normaliseInputsOptionnels';
        $privilege[$clefModifiee] = $nouvelleValeur;

        $response = $this->from(route('privileges.tests'))
        ->post(route('privileges.tests'), $privilege->toArray())
        ->assertRedirect('/');
    }

    public function normaliseInputsOptionnelsProvider()
    {
        // [string $clefModifiee, $nouvelleValeur]
        return [
            'Privilege valide' => [Privilege::COL_INTITULE, 'intitule'],

            // Aucun argument optionnel pour l'instant
        ];
    }

    /**
     * @depends testNormaliseInputsOptionnels
     * @dataProvider validerFormProvider
     */
    public function testValiderForm(bool $possedeErreur, string $clefModifiee, $nouvelleValeur)
    {
        $privilege                = factory(Privilege::class)->make();
        $privilege['test']        = 'validerForm';
        $privilege[$clefModifiee] = $nouvelleValeur;

        $routeSource = route('privileges.tests');
        $response = $this->from($routeSource)
        ->post(route('privileges.tests'), $privilege->toArray());

        if($possedeErreur)
        {
            $response->assertSessionHasErrors($clefModifiee)
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
        // [bool $possedeErreur, string $clefModifiee, $nouvelleValeur]
        return [
            // Succes
            'Intitule valide' => [FALSE, Privilege::COL_INTITULE, 'intitule'],

            // Echec
            'Privilege invalide' => [TRUE, Privilege::COL_INTITULE, -1],
        ];
    }

    /**
     * @dataProvider validerModeleProvider
     */
    public function testValiderModele(int $idCase, int $statutAttendu)
    {
        $privilege = factory(Privilege::class)->create();
        $id;
        switch($idCase)
        {
            case 0: 
                $id = $privilege->id; 
            break;

            case 1: 
                $id = "$privilege->id"; 
            break;

            case 2: 
                $id = -1; 
            break;

            case 3: 
                $id = null; 
            break;
        }
        
        $response = $this->followingRedirects()
        ->from(route('privileges.tests'))
        ->post(route('privileges.tests'), [
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
        // return Schema::getColumnListing(Template::NOM_TABLE);
    }
}