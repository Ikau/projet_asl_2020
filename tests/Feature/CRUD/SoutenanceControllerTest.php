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
        ->assertViewIs('admin.modeles.soutenance.index')
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
        ->assertViewIs('admin.modeles.soutenance.form')
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
        $soutenance = factory(Soutenance::class)->make();

        // Verification de la route
        $response = $this->followingRedirects()
        ->from(route('soutenances.create'))
        ->post(route('soutenances.store'), $soutenance->toArray())
        ->assertViewIs('admin.modeles.soutenance.index');

        // Verification de l'insertion
        $clauseWhere = [];
        foreach($this->getAttributsModele() as $attribut)
        {
            if('id' !== $attribut)
            {
                $clauseWhere[] = [$attribut, '=', $soutenance[$attribut]];
            }
        }

        $soutenanceTest = Soutenance::where($clauseWhere)->first();
        $this->assertNotNull($soutenanceTest);
        foreach($this->getAttributsModele() as $a)
        {
            if('id' !== $a)
            {
                $this->assertEquals($soutenance[$a], $soutenanceTest[$a]);
            }
        }

    }

    /**
     * @depends testValiderModele
     */
    public function testShow()
    {
        $soutenance = factory(Soutenance::class)->create();

        // Verification route
        $response = $this->from(route('soutenances.tests'))
        ->get(route('soutenances.show', $soutenance->id))
        ->assertViewIs('admin.modeles.soutenance.show')
        ->assertSee(SoutenanceController::TITRE_SHOW);

        // Verification integrite des donnees
        foreach($this->getAttributsModele() as $attribut)
        {
            $response->assertSee($soutenance[$attribut]);
        }

        // Verification echec
        $response = $this->from(route('soutenances.tests'))
        ->get(route('soutenances.show', -1))
        ->assertStatus(404);
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     */
    public function testEdit()
    {
        $soutenance = factory(Soutenance::class)->create();

        // Verification redirection
        $response = $this->from(route('soutenances.tests'))
        ->get(route('soutenances.edit', $soutenance->id))
        ->assertViewIs('admin.modeles.soutenance.form')
        ->assertSee(SoutenanceController::TITRE_EDIT);

        // Verification integrite des donnees
        foreach($this->getAttributsModele() as $attribut)
        {
            $response->assertSee($soutenance[$attribut]);
        }

        // Verification echec
        $response = $this->from(route('soutenances.tests'))
        ->get(route('soutenances.edit', -1))
        ->assertStatus(404);
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     * @dataProvider updateProvider
     */
    public function testUpdate(string $clefModifiee, $nouvelleValeur)
    {
        $soutenance = factory(Soutenance::class)->create();
        $soutenance[$clefModifiee] = $nouvelleValeur;

        // Verification route
        $response = $this->from(route('soutenances.tests'))
        ->patch(route('soutenances.update', $soutenance->id), $soutenance->toArray())
        ->assertRedirect(route('soutenances.index'));

        // Verificaiton de la modification
        $soutenanceTest = Soutenance::find($soutenance->id);
        foreach($this->getAttributsModele() as $a)
        {
            $this->assertEquals($soutenance[$a], $soutenanceTest[$a]);
        }
    }

    public function updateProvider()
    {
        // [string $clefModifiee, $nouvelleValeur]
        return [
            'Annee valide'          => [Soutenance::COL_ANNEE_ETUDIANT, 5],
            'Campus valide'         => [Soutenance::COL_CAMPUS, 'Bourges'],
            'Commentaire valide'    => [Soutenance::COL_COMMENTAIRE, 'Commentaire valide'],
            'Confidentielle valide' => [Soutenance::COL_CONFIDENTIELLE, TRUE],
            'Date valide'           => [Soutenance::COL_DATE, date('Y-m-d', strtotime('now +1 day'))],
            'Heure valide'          => [Soutenance::COL_HEURE, '12:00:00'],
            'Invites valide'        => [Soutenance::COL_INVITES, 'John Doe'],
            'Nombre repas valide'   => [Soutenance::COL_NB_REPAS, 2],
            'Salle valide'          => [Soutenance::COL_SALLE, 'SA.101'],
            'Candide valide'        => [Soutenance::COL_CANDIDE_ID, 1],
            //'Contact valide'        => [Soutenance::COL_CONTACT_ENTREPRISE_ID, 1],
            'Departement valide'    => [Soutenance::COL_DEPARTEMENT_ID, 1],
            'Etudiant valide'       => [Soutenance::COL_ETUDIANT_ID, 1],
            'Option valide'         => [Soutenance::COL_OPTION_ID, 1],
            'Referent valide'       => [Soutenance::COL_REFERENT_ID, 1],

            'Commentaire null'     => [Soutenance::COL_COMMENTAIRE, null],
            'Confidentielle null'  => [Soutenance::COL_CONFIDENTIELLE, null],
            'Invite null'          => [Soutenance::COL_INVITES, null],
            'Nombre de repas null' => [Soutenance::COL_NB_REPAS, null],
        ];
    }

    /**
     * @depends testValiderModele
     */
    public function testDestroy()
    {
        $soutenance = factory(Soutenance::class)->create();

        // Verification route
        $response = $this->from(route('soutenances.tests'))
        ->delete(route('soutenances.destroy', $soutenance->id))
        ->assertRedirect(route('soutenances.index'));

        // Verification suppression
        $soutenanceTest = Soutenance::find($soutenance->id);
        $this->assertNull($soutenanceTest);

        // Verification echec
        $response = $this->from(route('soutenances.tests'))
        ->delete(route('soutenances.destroy', -1))
        ->assertStatus(404);
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
