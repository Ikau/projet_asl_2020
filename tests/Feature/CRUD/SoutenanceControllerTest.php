<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Modeles\Soutenance;
use App\Http\Controllers\CRUD\SoutenanceController;
use App\Utils\Constantes;

class SoutenanceControllerTest extends TestCase
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
        $soutenance                = factory(Soutenance::class)->make();
        $soutenance['test']        = 'normaliseInputsOptionnels';
        $soutenance[$clefModifiee] = $nouvelleValeur;

        $response = $this->from(route('soutenances.tests'))
        ->post(route('soutenances.tests', $soutenance->toArray()))
        ->assertRedirect('/');
    }

    public function normaliseInputsOptionnelsProvider()
    {
        return [
            'Soutenance valide' => [Soutenance::COL_ANNEE_ETUDIANT, 4],

            'Commentaire null'    => [Soutenance::COL_COMMENTAIRE, null],
            'Invites null'        => [Soutenance::COL_INVITES, null],
            'Confidentielle null' => [Soutenance::COL_CONFIDENTIELLE, null],
            'Nombre repas null'   => [Soutenance::COL_NB_REPAS, null],

            'Commentaire vide'    => [Soutenance::COL_COMMENTAIRE, ''],
            'Invites vide'        => [Soutenance::COL_INVITES, ''],
            'Confidentielle vide' => [Soutenance::COL_CONFIDENTIELLE, ''],
            'Nombre repas vide'   => [Soutenance::COL_NB_REPAS, ''],

            'Commentaire invalide'    => [Soutenance::COL_COMMENTAIRE, -1],
            'Invites invalide'        => [Soutenance::COL_INVITES, -1],
            'Confidentielle invalide' => [Soutenance::COL_CONFIDENTIELLE, 'invalide'],
            'Nombre repas invalide'   => [Soutenance::COL_NB_REPAS, 'invalide'],
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
        $response = $this->get(route('soutenances.index'))
        ->assertOk()
        ->assertViewIs('soutenance.index')
        ->assertSee(SoutenanceController::TITRE_INDEX);

        foreach($this->getAttributsModele() as $attribut)
        {
            $response->assertSee("<th>$attribut</th>");
        }
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
        return Schema::getColumnListing(Soutenance::NOM_TABLE);
    }
}