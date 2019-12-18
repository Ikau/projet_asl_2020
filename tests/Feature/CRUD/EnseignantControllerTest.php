<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Modeles\Enseignant;
use App\Modeles\Departement;
use App\Modeles\Option;
use App\Http\Controllers\CRUD\EnseignantController;
use App\Utils\Constantes;

class EnseignantControllerTest extends TestCase
{
    // Rollback les modifications de la BDD a la fin des tests
    use RefreshDatabase;

    /* ====================================================================
     *                           TESTS AUXILIAIRES
     * ====================================================================
     */

     /**
      * @dataProvider normaliseOptionnelsProvider
      */
    public function testNormaliseOptionnels(string $clefModifiee, $nouvelleValeur)
    {
        $donnee                = factory(Enseignant::class)->make()->toArray();
        $donnee['test']        = 'normaliseInputsOptionnels';
        $donnee[$clefModifiee] = $nouvelleValeur;

        $response = $this->from(route('enseignants.tests'))
        ->post(route('enseignants.tests'), $donnee)
        ->assertRedirect('/'); // 404 est renvoye si non numerique, 500 si affectation par defaut echoue
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
        $id;
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
        ->assertViewIs('enseignant.index')
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
        ->assertViewIs('enseignant.form')
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
            ->assertSee("<option value=\"$departement->id\">$departement->intitule</option>");
        }

        // Verification des options
        foreach(Option::all() as $option)
        {
            $response->assertSee("<option value=\"$option->id\">$option->intitule</option>");
        }
    }
    
    /**
     * @depends testValiderForm
     * @depends testNormaliseOptionnels
     */
    public function testStore()
    {
        $enseignant = factory(Enseignant::class)->make();

        $response = $this->from(route('enseignants.create'))
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
        ->assertViewIs('enseignant.show')
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
        ->assertViewIs('enseignant.form')
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
    public function testUpdate(string $clefModifiee, $nouvelleValeur, $valeurDefaut)
    {
        $enseignantSource                = factory(Enseignant::class)->create();
        $enseignantSource[$clefModifiee] = $nouvelleValeur;
        
        // Mise a jour et redirection OK
        $response = $this->from(route('enseignants.edit', $enseignantSource->id))
        ->patch(route('enseignants.update', $enseignantSource->id), $enseignantSource->toArray())
        ->assertRedirect(route('enseignants.index'));

        // Definition du defaut si necessaire
        if('departement' === $valeurDefaut)
        {
            $idAucunDepartement = Departement::where(Departement::COL_INTITULE, 'Aucun')->first()->id;
            $enseignantSource[$clefModifiee] = $idAucunDepartement;
        }
        else if('option' === $valeurDefaut)
        {
            $idAucuneOption = Option::where(Option::COL_INTITULE, 'Aucune')->first()->id;
            $enseignantSource[$clefModifiee] = $idAucuneOption;
        }

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
        //[string $clefModifiee, $nouvelleValeur, $valeurDefaut]
        return [
            'Nom valide'         => [Enseignant::COL_NOM, 'nouveau', null],
            'Prenom valide'      => [Enseignant::COL_PRENOM, 'nouveau', null],
            'Mail valide'        => [Enseignant::COL_EMAIL, 'nouveau@example.com', null],
            'Departement valide' => [Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID, 1, null],
            'Option valide'      => [Enseignant::COL_RESPONSABLE_OPTION_ID, 1, null],

            'Departement null' => [Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID, null, 'departement'],
            'Option null'      => [Enseignant::COL_RESPONSABLE_OPTION_ID, null, 'option'],
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