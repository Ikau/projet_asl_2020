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
     * @dataProvider validerFormProvider
     */
    public function testValiderForm(bool $possedeErreur, string $clefModifiee, $nouvelleValeur)
    {
        $entreprise                = factory(Entreprise::class)->make();
        $entreprise['test']        = 'validerForm';
        $entreprise[$clefModifiee] = $nouvelleValeur;

        $routeSource = route('entreprises.tests');
        $response = $this->from($routeSource)
        ->post(route('entreprises.tests'), $entreprise->toArray());

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
            'Nom valide'      => [FALSE, Entreprise::COL_NOM, 'nom'],
            'Adresse valide'  => [FALSE, Entreprise::COL_ADRESSE, 'adresse'],
            'Ville valide'    => [FALSE, Entreprise::COL_VILLE, 'ville'],
            'Pays valide'     => [FALSE, Entreprise::COL_PAYS, 'pays'],
            'Adresse2 valide' => [FALSE, Entreprise::COL_ADRESSE2, 'adresse2'],
            'CP valide'       => [FALSE, Entreprise::COL_CP, 'cp'],
            'Region valide'   => [FALSE, Entreprise::COL_REGION, 'region'],

            'Adresse2 null' => [FALSE, Entreprise::COL_ADRESSE2, null],
            'CP null'       => [FALSE, Entreprise::COL_CP, null],
            'Region null'   => [FALSE, Entreprise::COL_REGION, null],

            // Echecs
            'Nom null'      => [TRUE, Entreprise::COL_NOM, null],
            'Adresse null'  => [TRUE, Entreprise::COL_ADRESSE, null],
            'Ville null'    => [TRUE, Entreprise::COL_VILLE, null],
            'Pays null'     => [TRUE, Entreprise::COL_PAYS, null],

            'Nom invalide'      => [TRUE, Entreprise::COL_NOM, -1],
            'Adresse invalide'  => [TRUE, Entreprise::COL_ADRESSE, -1],
            'Ville invalide'    => [TRUE, Entreprise::COL_VILLE, -1],
            'Pays invalide'     => [TRUE, Entreprise::COL_PAYS, -1],
            'Adresse2 invalide' => [TRUE, Entreprise::COL_ADRESSE2, -1],
            'CP invalide'       => [TRUE, Entreprise::COL_CP, -1],
            'Region invalide'   => [TRUE, Entreprise::COL_REGION, -1],
        ];
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