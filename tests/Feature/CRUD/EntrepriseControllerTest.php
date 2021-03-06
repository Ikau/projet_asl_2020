<?php

namespace Tests\Feature\CRUD;

use App\Http\Controllers\CRUD\EntrepriseController;
use App\Modeles\Entreprise;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EntrepriseControllerTest extends TestCase
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
        $entreprise = factory(Entreprise::class)->create();

        // Verification succes
        $response = $this->from(route('entreprises.tests'))
        ->post(route('entreprises.tests'), [
            'test' => 'validerModele',
            'id'   => $entreprise->id
        ])->assertRedirect('/');

        // Verification echec
        $responsse = $this->post(route('entreprises.tests'), [
            'test' => 'validerModele',
            'id'   => -1
        ])->assertStatus(404);
    }

    /* ====================================================================
     *                           TESTS RESOURCES
     * ====================================================================
     */

    public function testIndex()
    {
        $response = $this->from(route('entreprises.tests'))
        ->get(route('entreprises.index'))
        ->assertViewIs('admin.modeles.entreprise.index')
        ->assertSee(EntrepriseController::TITRE_INDEX);

        foreach($this->getAttributsModele() as $attribut)
        {
            $response->assertSee("<th>$attribut</th>");
        }
    }

    public function testCreate()
    {
        $response = $this->from(route('entreprises.tests'))
        ->get(route('entreprises.create'))
        ->assertViewIs('admin.modeles.entreprise.form')
        ->assertSee(EntrepriseController::TITRE_CREATE);

        foreach($this->getAttributsModele() as $attribut)
        {
            if('id' !== $attribut)
            {
                $response->assertSee($attribut);
            }
        }
    }

    /**
     * @depends testValiderForm
     */
    public function testStore()
    {
        $entreprise = factory(Entreprise::class)->make();

        // Verification de la redirection
        $response = $this->from(route('entreprises.create'))
        ->post(route('entreprises.store'), $entreprise->toArray())
        ->assertRedirect(route('entreprises.index'));

        // Verification de la sauvegarde
        $attributs   = $this->getAttributsModele();
        $clauseWhere = [];
        foreach($attributs as $attribut)
        {
            if('id' !== $attribut)
            {
                $clauseWhere[] = [$attribut, '=', $entreprise[$attribut]];
            }
        }

        $entrepriseTest = Entreprise::where($clauseWhere)->first();
        $this->assertNotNull($entrepriseTest);
        foreach($attributs as $attribut)
        {
            if('id' !== $attribut)
            {
                $this->assertEquals($entreprise[$attribut], $entrepriseTest[$attribut]);
            }
        }
    }

    /**
     * @depends testValiderModele
     */
    public function testShow()
    {
        $entreprise = factory(Entreprise::class)->create();

        // Succes
        $response = $this->from(route('entreprises.tests'))
        ->get(route('entreprises.show', $entreprise->id))
        ->assertOk()
        ->assertViewIs('admin.modeles.entreprise.show')
        ->assertSee(e(EntrepriseController::TITRE_SHOW));

        foreach($this->getAttributsModele() as $attribut)
        {
            $response->assertSee($attribut)
            ->assertSee(e($entreprise[$attribut]));
        }

        // Echec
        $this->get(route('entreprises.show', -1))
        ->assertStatus(404);
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     */
    public function testEdit()
    {
        $entreprise = factory(Entreprise::class)->create();

        // Succes
        $response = $this->from(route('entreprises.tests'))
        ->get(route('entreprises.edit', $entreprise->id))
        ->assertOk()
        ->assertViewIs('admin.modeles.entreprise.form')
        ->assertSee(EntrepriseController::TITRE_EDIT);

        foreach($this->getAttributsModele() as $a)
        {
            $response->assertSee(e($entreprise[$a]));
        }

        // Echec
        $this->get(route('entreprises.edit', -1))
        ->assertStatus(404);
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
