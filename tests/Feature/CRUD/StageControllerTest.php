<?php

namespace Tests\Feature\CRUD;

use App\Http\Controllers\CRUD\StageController;
use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Stage;
use App\Traits\TestFiches;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class StageControllerTest extends TestCase
{
    use TestFiches;

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

        $response = $this->from(route('stages.tests'))
        ->post(route('stages.tests'), $stage->toArray())
        ->assertRedirect('/');
    }

    public function normaliseOptionnelsProvider()
    {
        // [string $clefModifiee, $nouvelleValeur]
        return [
            'Convention envoyee valide' => [Stage::COL_CONVENTION_ENVOYEE, FALSE],
            'Convention signee valide'  => [Stage::COL_CONVENTION_SIGNEE, FALSE],
            'Moyen de recherche valide' => [Stage::COL_MOYEN_RECHERCHE, 'valide'],
            'Referent valide'           => [Stage::COL_REFERENT_ID, 1], // Ref 'Aucun' par defaut

            'Convention envoyee null' => [Stage::COL_CONVENTION_ENVOYEE, null],
            'Convention signee null'  => [Stage::COL_CONVENTION_SIGNEE, null],
            'Moyen de recherche null' => [Stage::COL_MOYEN_RECHERCHE, null],
            'Referent null'           => [Stage::COL_REFERENT_ID, null],

            'Convention envoyee invalide' => [Stage::COL_CONVENTION_ENVOYEE, 'invalide'],
            'Convention signee invalide'  => [Stage::COL_CONVENTION_SIGNEE, 'invalide'],
            'Moyen de recherche invalide' => [Stage::COL_MOYEN_RECHERCHE, -1],
            'Referent invalide'           => [Stage::COL_REFERENT_ID, -1],
        ];
    }

    /**
     * @depends testNormaliseOptionnels
     * @dataProvider validerFormProvider
     */
    public function testValiderForm(bool $possedeErreur, string $clefModifiee, $nouvelleValeur)
    {
        $stage                = factory(Stage::class)->make();
        $stage['test']        = 'validerForm';
        $stage[$clefModifiee] = $nouvelleValeur;

        $routeSource = route('stages.tests');
        $response = $this->from($routeSource)
        ->post(route('stages.tests'), $stage->toArray());

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
            'Annee valide'          => [FALSE, Stage::COL_ANNEE, 4],
            'Date debut valide'     => [FALSE, Stage::COL_DATE_DEBUT, date('Y-m-d', strtotime('now +1 day'))],
            'Date fin valide'       => [FALSE, Stage::COL_DATE_FIN, '3001-01-01'],
            'Duree semaines valide' => [FALSE, Stage::COL_DUREE_SEMAINES, 24],
            'Gratification valide'  => [FALSE, Stage::COL_GRATIFICATION, 800.00],
            'Intitule valide'       => [FALSE, Stage::COL_INTITULE, 'intitule'],
            'Lieu valide'           => [FALSE, Stage::COL_LIEU, 'lieu'],
            'Resume valide'         => [FALSE, Stage::COL_RESUME, 'resume'],

            'Duree semaines float' => [FALSE, Stage::COL_DUREE_SEMAINES, (float)24.0],
            'Gratification int'    => [FALSE, Stage::COL_GRATIFICATION, (int)800],

            'Duree semaines numerique' => [FALSE, Stage::COL_DUREE_SEMAINES, '24'],
            'Gratification numerique'  => [FALSE, Stage::COL_GRATIFICATION, '800'],

            'Convention envoyee null' => [FALSE, Stage::COL_CONVENTION_ENVOYEE, null],
            'Convention signee null'  => [FALSE, Stage::COL_CONVENTION_SIGNEE, null],
            'Moyen de recherche null' => [FALSE, Stage::COL_MOYEN_RECHERCHE, null],

            // Echecs
            'Annee null'          => [TRUE, Stage::COL_ANNEE, null],
            'Date debut null'     => [TRUE, Stage::COL_DATE_DEBUT, null],
            'Date fin null'       => [TRUE, Stage::COL_DATE_FIN, null],
            'Duree semaines null' => [TRUE, Stage::COL_DUREE_SEMAINES, null],
            'Gratification null'  => [TRUE, Stage::COL_GRATIFICATION, null],
            'Intitule null'       => [TRUE, Stage::COL_INTITULE, null],
            'Lieu null'           => [TRUE, Stage::COL_LIEU, null],
            'Resume null'         => [TRUE, Stage::COL_RESUME, null],

            'Annee invalide'            => [TRUE, Stage::COL_ANNEE, 'invalide'],
            'Date debut apres date fin' => [TRUE, Stage::COL_DATE_DEBUT, '3000-01-01'],
            'Date fin avant date debut' => [TRUE, Stage::COL_DATE_FIN, '2000-01-01'],
            'Duree semaines invalide'   => [TRUE, Stage::COL_DUREE_SEMAINES, 'invalde'],
            'Gratification invalide'    => [TRUE, Stage::COL_GRATIFICATION, 'invalide'],
            'Intitule invalide'         => [TRUE, Stage::COL_INTITULE, -1],
            'Lieu invalide'             => [TRUE, Stage::COL_LIEU, -1],
            'Resume invalide'           => [TRUE, Stage::COL_RESUME, -1],

            'Convention envoyee invalide' => [TRUE, Stage::COL_CONVENTION_ENVOYEE, 'invalide'],
            'Convention signee invalide'  => [TRUE, Stage::COL_CONVENTION_SIGNEE, 'invalide'],
            'Moyen de recherche invalide' => [TRUE, Stage::COL_MOYEN_RECHERCHE, -1],
        ];
    }

    /**
     * @dataProvider validerModeleProvider
     */
    public function testValiderModele(int $idCase, int $statutAttendu)
    {
        $stage = factory(Stage::class)->create();
        $id = null;
        switch($idCase)
        {
            case 0:
                $id = $stage->id;
            break;

            case 1:
                $id = "$stage->id";
            break;

            case 2:
                $id = -1;
            break;

            case 3:
                $id = null;
            break;
        }

        $response = $this->followingRedirects()
        ->from(route('stages.tests'))
        ->post(route('stages.tests'), [
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
        $response = $this->get(route('stages.index'))
        ->assertOk()
        ->assertViewIs('admin.modeles.stage.index')
        ->assertSee(StageController::TITRE_INDEX);

        foreach($this->getAttributsModele() as $a)
        {
            if(Stage::COL_RESUME !== $a)
            {
                $response->assertSee("<th>$a</th>");
            }
        }
    }

    public function testCreate()
    {
        $response = $this->get(route('stages.create'))
        ->assertOk()
        ->assertViewIs('admin.modeles.stage.form')
        ->assertSee(StageController::TITRE_CREATE);

        foreach($this->getAttributsModele() as $a)
        {
            if('id' !== $a && Stage::COL_AFFECTATION_VALIDEE !== $a)
            {
                $response->assertSee($a);
            }
        }
    }

    /**
     * @depends testValiderForm
     */
    public function testStore()
    {
        // Creation d'un utilisateur aleatoire
        $user = $this->creerUserRoleEnseignant();

        $stage = factory(Stage::class)->make();

        // Verification de la route
        $response = $this->actingAs($user)
        ->followingRedirects()
        ->from(route('stages.create'))
        ->post(route('stages.store'), $stage->toArray())
        ->assertViewIs('enseignant.commun.index')
        ->assertSee('Stage ajoute !');

        // Verification de l'insertion
        $clauseWhere = [];
        foreach($this->getAttributsModele() as $attribut)
        {
            if('id' !== $attribut)
            {
                $clauseWhere[] = [$attribut, '=', $stage[$attribut]];
            }
        }

        // Integrite des donnees
        $stageTest = Stage::where($clauseWhere)->first();
        $this->assertNotNull($stageTest);
        foreach($this->getAttributsModele() as $a)
        {
            if('id' !== $a)
            {
                $this->assertEquals($stage[$a], $stageTest[$a]);
            }
        }

        // Verification relation avec les fiches

        $ficheRapportTest = FicheRapport::where(FicheRapport::COL_STAGE_ID, '=', $stageTest->id)->first();
        $this->assertNotNull($ficheRapportTest);
        $this->assertFichesRapportEgales($ficheRapportTest, $stageTest->fiche_rapport);
    }

    /**
     * @depends testValiderModele
     */
    public function testShow()
    {
        $stage = factory(Stage::class)->create();

        $response = $this->from(route('stages.tests'))
        ->get(route('stages.show', $stage->id))
        ->assertViewIs('admin.modeles.stage.show')
        ->assertSee(StageController::TITRE_SHOW);

        foreach($this->getAttributsModele() as $attribut)
        {
            if('id' !== $attribut)
            {
                // Fonction e() pour les cas avec apostrophes echapes (')
                $response->assertSee(e($stage[$attribut]));
            }
        }
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     */
    public function testEdit()
    {
        $stage = factory(Stage::class)->create();

        $response = $this->from(route('stages.tests'))
        ->get(route('stages.edit', $stage->id))
        ->assertViewIs('admin.modeles.stage.form')
        ->assertSee(StageController::TITRE_EDIT);

        foreach($this->getAttributsModele() as $attribut)
        {
            // La fonction e() echappe les apostrophes, chose faite par Blade automatiquement
            $response->assertSee(e($stage[$attribut]));
        }
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     * @dataProvider updateProvider
     */
    public function testUpdate(string $clefModifiee, $nouvelleValeur)
    {
        $stage                = factory(Stage::class)->create();
        $stage[$clefModifiee] = $nouvelleValeur;

        // Verification redirection
        $response = $this->from(route('stages.index'))
        ->patch(route('stages.update', $stage->id), $stage->toArray())
        ->assertRedirect(route('stages.index'));

        // Verification modification
        $stageTest = Stage::find($stage->id);
        foreach($this->getAttributsModele() as $a)
        {
            $this->assertEquals($stage[$a], $stageTest[$a]);
        }
    }

    public function updateProvider()
    {
        //[string $clefModifiee, $nouvelleValeur]
        return [
            'Annee valide'          => [Stage::COL_ANNEE, 4],
            'Date debut valide'     => [Stage::COL_DATE_DEBUT, date('Y-m-d', strtotime('now +1 day'))],
            'Date fin valide'       => [Stage::COL_DATE_FIN, '3001-01-01'],
            'Duree semaines valide' => [Stage::COL_DUREE_SEMAINES, 24],
            'Gratification valide'  => [Stage::COL_GRATIFICATION, 800.00],
            'Intitule valide'       => [Stage::COL_INTITULE, 'intitule'],
            'Lieu valide'           => [Stage::COL_LIEU, 'lieu'],
            'Resume valide'         => [Stage::COL_RESUME, 'resume'],

            'Duree semaines float' => [Stage::COL_DUREE_SEMAINES, (float)24.0],
            'Gratification int'    => [Stage::COL_GRATIFICATION, (int)800],

            'Duree semaines numerique' => [Stage::COL_DUREE_SEMAINES, '24'],
            'Gratification numerique'  => [Stage::COL_GRATIFICATION, '800'],

            'Convention envoyee null' => [Stage::COL_CONVENTION_ENVOYEE, null],
            'Convention signee null'  => [Stage::COL_CONVENTION_SIGNEE, null],
            'Moyen de recherche null' => [Stage::COL_MOYEN_RECHERCHE, null],
        ];
    }

    /**
     * @depends testValiderModele
     */
    public function testDestroy()
    {
        $stage = factory(Stage::class)->create();

        $response = $this->from(route('stages.tests'))
        ->delete(route('stages.destroy', $stage->id))
        ->assertRedirect(route('stages.index'));

        $stageTest = Stage::find($stage->id);
        $this->assertNull($stageTest);
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
        return Schema::getColumnListing(Stage::NOM_TABLE);
    }
}
