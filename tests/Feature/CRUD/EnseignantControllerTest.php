<?php

namespace Tests\Feature\CRUD;

use App\Http\Controllers\CRUD\EnseignantController;
use App\Modeles\Departement;
use App\Modeles\Enseignant;
use App\Modeles\Option;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class EnseignantControllerTest extends TestCase
{
    /* ====================================================================
     *                           TESTS AUXILIAIRES
     * ====================================================================
     */

     /**
      * @dataProvider normaliseOptionnelsProvider
      */
    public function testNormaliseOptionnels(string $clefModifiee, $nouvelleValeur)
    {
        // Construction de l'objet
        $enseignant                = factory(Enseignant::class)->make();
        $enseignant['test']        = 'normaliseInputsOptionnels';
        $enseignant[$clefModifiee] = $nouvelleValeur;

        // Test
        $this->from(route('enseignants.tests'))
        ->post(route('enseignants.tests'), $enseignant->toArray())
        ->assertRedirect('/');
    }

    public function normaliseOptionnelsProvider()
    {
        //[string $clefModifiee, $nouvelleValeur]
        return [
            // Success
            'Resp departement null'     => [Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID, null],
            'Resp option null'          => [Enseignant::COL_RESPONSABLE_OPTION_ID, null],

            'Resp departement numerique' => [Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID, '1'],
            'Resp option numerique'      => [Enseignant::COL_RESPONSABLE_OPTION_ID, '1'],

            'Resp departement non numerique' => [Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID, ''],
            'Resp option non numerique'      => [Enseignant::COL_RESPONSABLE_OPTION_ID, ''],

            'Resp departement invalide' => [Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID, -1],
            'Resp option invalide'      => [Enseignant::COL_RESPONSABLE_OPTION_ID, -1],
        ];
    }

    /**
     * @dataProvider validerFormProvider
     */
    public function testValiderForm(bool $possedeErreur, string $clefModifiee, $nouvelleValeur)
    {
        $enseignant                = factory(Enseignant::class)->make();
        $enseignant['test']        = 'validerForm';
        $enseignant[$clefModifiee] = $nouvelleValeur;

        $routeSource = route('enseignants.tests');
        $response = $this->from($routeSource)
        ->post(route('enseignants.tests'), $enseignant->toArray());

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
        //[bool $possedeErreur, string $clefModifiee, $nouvelleValeur]
        return [
            // Succes
            'Nom valide'         => [FALSE, Enseignant::COL_NOM, 'nom'],
            'Prenom valide'      => [FALSE, Enseignant::COL_PRENOM, 'prenom'],
            'Email valide'       => [FALSE, Enseignant::COL_EMAIL, 'valide@example.com'],
            'Departement valide' => [FALSE, Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID, 1],
            'Option valide'      => [FALSE, Enseignant::COL_RESPONSABLE_OPTION_ID, 1],

            'Departement non numerique' => [FALSE, Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID, ''],
            'Option non numerique'      => [FALSE, Enseignant::COL_RESPONSABLE_OPTION_ID, ''],

            'Departement null' => [FALSE, Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID, null],
            'Option null'      => [FALSE, Enseignant::COL_RESPONSABLE_OPTION_ID, null],

            // Echecs
            'Nom null'         => [TRUE, Enseignant::COL_NOM, null],
            'Prenom null'      => [TRUE, Enseignant::COL_PRENOM, null],
            'Email null'       => [TRUE, Enseignant::COL_EMAIL, null],

            'Departement invalide' => [TRUE, Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID, -1],
            'Option invalide'      => [TRUE, Enseignant::COL_RESPONSABLE_OPTION_ID, -1],
            'Email invalide'       => [TRUE, Enseignant::COL_EMAIL, 'invalideEmail'],
        ];
    }

    /**
     * @dataProvider validerModeleProvider
     */
    public function testValiderModele(int $casId, int $statutAttendu)
    {
        $enseignant = factory(Enseignant::class)->create();
        $id = -1;
        switch($casId)
        {
            case 0:
                $id = $enseignant->id;
            break;

            case 1:
                $id = "$enseignant->id";
            break;

            case 2:
                $id = -1;
            break;

            case 3:
                $id = null;
            break;
        }

        $response = $this->from(route('enseignants.tests'))
        ->post(route('enseignants.tests',[
            'id'   => $id,
            'test' => 'validerModele',
        ]))
        ->assertStatus($statutAttendu);
    }

    public function validerModeleProvider()
    {

        return [
            'Id valide'    => [0, 302],
            'Id numerique' => [1, 302],
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
        $response = $this->get(route('enseignants.index'))
        ->assertOk()
        ->assertViewIs('admin.modeles.enseignant.index')
        ->assertSee(EnseignantController::TITRE_INDEX);

        foreach($this->getAttributsModele() as $attribut)
        {
            $response->assertSee("<th>$attribut</th>");
        }
    }

    public function testCreate()
    {
        // Affichage de la page
        $response = $this->get(route('enseignants.create'))
        ->assertOK()
        ->assertViewIs('admin.modeles.enseignant.form')
        ->assertSee(EnseignantController::TITRE_CREATE);

        // Verification des inputs
        foreach($this->getAttributsModele() as $attribut)
        {
            if('id' !== $attribut)
            {
                $response->assertSee("name=\"$attribut\"");
            }
        }

        // Verification des departements
        foreach(Departement::all() as $departement)
        {
            $response->assertSee("<optgroup label=\"$departement->intitule\">")
            ->assertSee($departement->intitule);
        }

        // Verification des options
        foreach(Option::all() as $option)
        {
            $response->assertSee($option->intitule);
        }
    }

    /**
     * @depends testValiderForm
     * @depends testNormaliseOptionnels
     */
    public function testStore()
    {
        // Enseignant aleatoire
        $enseignant = factory(Enseignant::class)->make();

        // Routage OK
        $this->from(route('enseignants.create'))
        ->post(route('enseignants.store'), $enseignant->toArray())
        ->assertRedirect(route('enseignants.index'));

        // Arguments pour la clause 'where'
        $arrayWhere = [];
        foreach($this->getAttributsModele() as $attribut)
        {
            if('id' !== $attribut)
            {
                $arrayWhere[] = [$attribut, '=', $enseignant[$attribut]];
            }
        }

        // Recuperation de l'enseignant
        $enseignantTest = Enseignant::where($arrayWhere)->first();
        $this->assertNotNull($enseignantTest);

        // Integrite des donnees
        foreach($this->getAttributsModele() as $attribut)
        {
            if('id' !== $attribut)
            {
                $this->assertEquals($enseignant[$attribut], $enseignantTest[$attribut]);
            }
        }
    }

    /**
     * @depends testValiderModele
     */
    public function testShow()
    {
        $enseignant = factory(Enseignant::class)->create();

        $response = $this->get(route('enseignants.show', $enseignant->id))
        ->assertOk()
        ->assertViewIs('admin.modeles.enseignant.show')
        ->assertSee(EnseignantController::TITRE_SHOW);

        foreach($this->getAttributsModele() as $a)
        {
            $response->assertSee($enseignant[$a]);
        }
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     */
    public function testEdit()
    {
        $enseignant = factory(Enseignant::class)->create();

        $response = $this->get(route('enseignants.edit', $enseignant->id))
        ->assertOk()
        ->assertViewIs('admin.modeles.enseignant.form')
        ->assertSee(EnseignantController::TITRE_EDIT);

        foreach($this->getAttributsModele() as $attribut)
        {
            $response->assertSee($enseignant[$attribut]);
        }
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     * @dataProvider updateProvider
     */
    public function testUpdate(string $clefModifiee, $nouvelleValeur)
    {
        $enseignantSource                = factory(Enseignant::class)->create();
        $enseignantSource[$clefModifiee] = $nouvelleValeur;

        // Mise a jour et redirection OK
        $response = $this->from(route('enseignants.edit', $enseignantSource->id))
        ->patch(route('enseignants.update', $enseignantSource->id), $enseignantSource->toArray())
        ->assertRedirect(route('enseignants.index'));

        // Verification de la MAJ
        $enseignantMaj = Enseignant::find($enseignantSource->id);
        $this->assertNotNull($enseignantMaj);
        foreach($this->getAttributsModele() as $a)
        {
            $this->assertEquals($enseignantSource[$a], $enseignantMaj[$a]);
        }
    }

    public function updateProvider()
    {
        //[string $clefModifiee, $nouvelleValeur]
        return [
            'Nom valide'         => [Enseignant::COL_NOM, 'nouveau'],
            'Prenom valide'      => [Enseignant::COL_PRENOM, 'nouveau'],
            'Mail valide'        => [Enseignant::COL_EMAIL, 'nouveau@example.com'],
            'Departement valide' => [Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID, 1],
            'Option valide'      => [Enseignant::COL_RESPONSABLE_OPTION_ID, 1],

            'Departement null' => [Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID, null],
            'Option null'      => [Enseignant::COL_RESPONSABLE_OPTION_ID, null],
        ];
    }

    /**
     * @depends testValiderModele
     */
    public function testDestroy()
    {
        $enseignant = factory(Enseignant::class)->create();

        $response = $this->from(route('enseignants.index'))
        ->delete(route('enseignants.destroy', $enseignant->id))
        ->assertRedirect(route('enseignants.index'));

        $this->assertNull(Enseignant::find($enseignant->id));
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
        return Schema::getColumnListing(Enseignant::NOM_TABLE);
    }
}
