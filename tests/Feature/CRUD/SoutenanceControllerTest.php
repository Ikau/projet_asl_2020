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
        // [string $clefModifiee, $nouvelleValeur]
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
     * @dataProvider validerFormProvider
     */
    public function testValiderForm(bool $possedeErreur, string $clefModifiee, $nouvelleValeur)
    {
        $soutenance                = factory(Soutenance::class)->make();
        $soutenance['test']        = 'validerForm';
        $soutenance[$clefModifiee] = $nouvelleValeur;

        $routeSource = route('soutenances.tests');
        $response = $this->from(route('soutenances.tests'))
        ->post(route('soutenances.tests'), $soutenance->toArray());

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
            'Soutenance valide' => [FALSE, Soutenance::COL_ANNEE_ETUDIANT, 4],
            
            'Commentaire null'     => [FALSE, Soutenance::COL_COMMENTAIRE, null],
            'Confidentielle null'  => [FALSE, Soutenance::COL_CONFIDENTIELLE, null],
            'Invite null'          => [FALSE, Soutenance::COL_INVITES, null],
            'Nombre de repas null' => [FALSE, Soutenance::COL_NB_REPAS, null],

            // Echecs
            'Annee etudiant null' => [TRUE, Soutenance::COL_ANNEE_ETUDIANT, null],
            'Date null'           => [TRUE, Soutenance::COL_DATE, null],
            'Heure null'          => [TRUE, Soutenance::COL_HEURE, null],
            'Salle null'          => [TRUE, Soutenance::COL_SALLE, null],
            'Candide null'        => [TRUE, Soutenance::COL_CANDIDE_ID, null],
            //'Contact null'         => [TRUE, Soutenance::COL_CONTACT_ID, null],
            'Departement null'    => [TRUE, Soutenance::COL_DEPARTEMENT_ID, null],
            'Option null'         => [TRUE, Soutenance::COL_OPTION_ID, null],
            'Rerefent null'       => [TRUE, Soutenance::COL_REFERENT_ID, null],

            'Annee etudiant invalide'  => [TRUE, Soutenance::COL_ANNEE_ETUDIANT, 'invalide'],
            'Commentaire invalide'     => [TRUE, Soutenance::COL_COMMENTAIRE, -1],
            'Confidentielle invalide'  => [TRUE, Soutenance::COL_CONFIDENTIELLE, 'invalide'],
            'Date invalide'            => [TRUE, Soutenance::COL_DATE, 'invalide'],
            'Heure invalide'           => [TRUE, Soutenance::COL_HEURE, 'invalide'],
            'Salle invalide'           => [TRUE, Soutenance::COL_SALLE, -1],
            'Candide invalide'         => [TRUE, Soutenance::COL_CANDIDE_ID, 'invalide'],
            //'Contact invalide'         => [TRUE, Soutenance::COL_CONTACT_ID, 'invalide'],
            'Departement invalide'     => [TRUE, Soutenance::COL_DEPARTEMENT_ID, 'invalide'],
            'Invite invalide'          => [TRUE, Soutenance::COL_INVITES, -1],
            'Nombre de repas invalide' => [TRUE, Soutenance::COL_NB_REPAS, 'invalide'],
            'Option invalide'          => [TRUE, Soutenance::COL_OPTION_ID, 'invalide'],
            'Rerefent invalide'        => [TRUE, Soutenance::COL_REFERENT_ID, 'invalide'],

            'Date depassee' => [TRUE, Soutenance::COL_DATE, date('Y-m-d', strtotime('now -1 day'))],

            'Candide inexistant'     => [TRUE, Soutenance::COL_CANDIDE_ID, -1],
            //'Contact inexistant'     => [TRUE, Soutenance::COL_CONTACT_ID, -1],
            'Departement inexistant' => [TRUE, Soutenance::COL_DEPARTEMENT_ID, -1],
            'Option inexistant'      => [TRUE, Soutenance::COL_OPTION_ID, -1],
            'Rerefent inexistant'    => [TRUE, Soutenance::COL_REFERENT_ID, -1],
            
            'Invite negatif'          => [TRUE, Soutenance::COL_INVITES, -1],
            'Nombre de repas negatif' => [TRUE, Soutenance::COL_NB_REPAS, -1],
        ];
    }

    /**
     * @dataProvider validerModeleProvider
     */
    public function testValiderModele(int $idCase, int $statutAttendu)
    {
        $soutenance = factory(Soutenance::class)->create();

        $id;
        switch($idCase)
        {
            case 0: 
                $id = $soutenance->id; 
            break;

            case 1: 
                $id = "$soutenance->id"; 
            break;

            case 2: 
                $id = -1; 
            break;

            case 3: 
                $id = null; 
            break;
        }
        
        $response = $this->followingRedirects()
        ->from(route('soutenances.tests'))
        ->post(route('soutenances.tests'), [
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
        $response = $this->get(route('soutenances.create'))
        ->assertOk()
        ->assertViewIs('soutenance.form.admin')
        ->assertSee(SoutenanceController::TITRE_CREATE);

        foreach($this->getAttributsModele() as $attribut)
        {
            if('id' !== $attribut
            //&& Soutenance::COL_CONTACT_ENTREPRISE_ID !== $attribut
            )
            {
                $response->assertSee("name=\"$attribut\"");
            }
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