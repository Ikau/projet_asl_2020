<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
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
        'responsable_departement'
    ];

    /* ====================================================================
     *                           TESTS AUXILIAIRES
     * ====================================================================
     */

     /**
      * @dataProvider normaliseOptionnelsProvider
      */
    public function testNormaliseOptionnels($clefModifiee)
    {
        $donnee                = factory(Enseignant::class)->make()->toArray();
        $donnee['test']        = 'normaliseInputsOptionnels';
        $donnee[$clefModifiee] = null;

        $response = $this->from(route('enseignants.tests'))
        ->post(route('enseignants.tests'), $donnee)
        ->assertRedirect('/');
    }

    public function normaliseOptionnelsProvider()
    {
        return [
          'Enseignant valide'         => ['aucune'] ,
          'Soutenances candide null'  => ['soutenances_candide'],
          'Soutenances referent null' => ['soutenances_referent'],
          'Stages null'               => ['stages'],
        ];
    }

    /**
     * @dataProvider validerFormProvider
     */
    public function testValiderForm(array $donnee, string $routeAttendue)
    {
        $response = $this->from(route('enseignants.tests'))
        ->post(route('enseignants.tests'), $donnee)
        ->assertRedirect($routeAttendue);

    }

    public function validerFormProvider()
    {
        // 'Fix' pour utiliser les factories dans les providers
        $this->refreshApplication();

        // Rappel : les affectations par array sont des copies profondes
        $enseignantValide = factory(Enseignant::class)->make()->toArray();
        $enseignantValide['test'] = 'validerForm';

        // Success
        $stagesNull           = $enseignantValide;
        $stagesInvalides      = $enseignantValide;
        $soutenancesNull      = $enseignantValide;
        $soutenancesInvalides = $enseignantValide;

        $stagesNull['stages']      = null;
        $stagesInvalides['stages'] = 'non_collection';
        $soutenancesNull['soutenances_referent']      = null;
        $soutenancesNull['soutenances_candide']       = null;
        $soutenancesInvalides['soutenances_referent'] = 'non_collection';
        $soutenancesInvalides['soutenances_candide']  = 'non_collection';

        // Echecs
        $nomNull         = $enseignantValide;
        $prenomNull      = $enseignantValide;
        $emailNull       = $enseignantValide;
        $optionNull      = $enseignantValide;
        $departementNull = $enseignantValide;

        $nomNull['nom']                             = null;
        $prenomNull['prenom']                       = null;
        $emailNull['email']                         = null;
        $optionNull['responsable_option']           = null;
        $departementNull['responsable_departement'] = null;

        $nomInvalide         = $enseignantValide;
        $prenomInvalide      = $enseignantValide;
        $emailInvalide       = $enseignantValide;
        $optionInvalide      = $enseignantValide;
        $departementInvalide = $enseignantValide;

        $nomInvalide['nom']                             = 42;
        $prenomInvalide['prenom']                       = 42;
        $emailInvalide['email']                         = 'mauvaisEmail';
        $optionInvalide['responsable_option']           = -1;
        $departementInvalide['responsable_departement'] = -1;

        // [array $donnee, string $routeAttendue]
        return [
            // Succes
            'Enseignant valide'     => [$enseignantValide, '/'],
            'Stages null'           => [$stagesNull, '/'],
            'Stages invalides'      => [$stagesInvalides, '/'],
            'Soutenances null'      => [$soutenancesNull, '/'],
            'Soutenances invalides' => [$soutenancesInvalides, '/'],

            // Echecs
            'Nom null'         => [$nomNull, route('enseignants.tests')],
            'Prenom null'      => [$prenomNull, route('enseignants.tests')],
            'Email null'       => [$emailNull, route('enseignants.tests')],
            'Option null'      => [$optionNull, route('enseignants.tests')],
            'Departement null' => [$departementNull, route('enseignants.tests')],

            'Nom invalide'         => [$nomInvalide, route('enseignants.tests')],
            'Prenom invalide'      => [$prenomInvalide, route('enseignants.tests')],
            'Email invalide'       => [$emailInvalide, route('enseignants.tests')],
            'Option invalide'      => [$optionInvalide, route('enseignants.tests')],
            'Departement invalide' => [$departementInvalide, route('enseignants.tests')],
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
        $response = $this->get(route('enseignants.index'))
        ->assertOk()
        ->assertViewIs('enseignant.index')
        ->assertSee(EnseignantController::TITRE_INDEX);
    }

    public function testCreate()
    {
        $response = $this->get(route('enseignants.create'))
        ->assertOK()
        ->assertViewIs('enseignant.form')
        ->assertSee(EnseignantController::TITRE_CREATE);
    }
    
    /**
     * @depends testValiderForm
     */
    public function testStore()
    {
        $enseignant = factory(Enseignant::class)->make();

        $response = $this->from(route('enseignants.create'))
        ->post(route('enseignants.store'), $enseignant->toArray())
        ->assertRedirect(route('enseignants.index'));

        // Arguments pour la clause 'where'
        $arrayWhere = [];
        foreach($this->attributs as $attribut)
        {
            $arrayWhere[] = [$attribut, '=', $enseignant[$attribut]];
        }
        
        // Recuperation de l'enseignant
        $enseignantTest = Enseignant::where($arrayWhere)->first();
        $this->assertNotNull($enseignantTest);

        foreach($this->attributs as $attribut)
        {
            $this->assertEquals($enseignant[$attribut], $enseignantTest[$attribut]);
        }
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