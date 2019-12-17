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
        'email'
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

        $nomNull[Enseignant::COL_NOM]                                = null;
        $prenomNull[Enseignant::COL_PRENOM]                          = null;
        $emailNull[Enseignant::COL_EMAIL]                            = null;
        $optionNull[Enseignant::COL_RESPONSABLE_OPTION_ID]           = null;
        $departementNull[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID] = null;

        $nomInvalide         = $enseignantValide;
        $prenomInvalide      = $enseignantValide;
        $emailInvalide       = $enseignantValide;
        $optionInvalide      = $enseignantValide;
        $departementInvalide = $enseignantValide;

        $nomInvalide[Enseignant::COL_NOM]                                = 42;
        $prenomInvalide[Enseignant::COL_PRENOM]                          = 42;
        $emailInvalide[Enseignant::COL_EMAIL]                            = 'mauvaisEmail';
        $optionInvalide[Enseignant::COL_RESPONSABLE_OPTION_ID]           = -1;
        $departementInvalide[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID] = -1;

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

    /**
     * @dataProvider validerModeleProvider
     */
    public function testValiderModele(string $casId, int $statutAttendu)
    {
        $id;
        switch($casId)
        {
            case 'id_valide':
                $enseignant = factory(Enseignant::class)->create();
                $id         = $enseignant->id;
            break;

            case 'id_numerique':
                $enseignant = factory(Enseignant::class)->create();
                $id         = "$enseignant->id";
            break;

            case 'id_invalide':
                $id = -1;
            break;

            case 'id_null':
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
            'Id valide'    => ['id_valide', 302],
            'Id numerique' => ['id_numerique', 302],
            'Id invalide'  => ['id_invalide', 404],
            'Id null'      => ['id_null', 404],
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
     * @dataProvider showEditDestroyProvider
     */
    public function testShow(string $idCas, bool $succes)
    {
        $id;
        switch($idCas)
        {
            case 'id_valide':
                $id = factory(Enseignant::class)->create()->id;
            break;

            case 'id_numerique':
                $enseignant = factory(Enseignant::class)->create();
                $id = "$enseignant->id";
            break;

            case 'id_invalide':
                $id = -1;
            break;
        }
        $response = $this->get(route('enseignants.show', $id));
        if($succes)
        {
            $response->assertOk()
            ->assertViewIs('enseignant.show')
            ->assertSee(EnseignantController::TITRE_SHOW);
        }
        else
        {
            $response->assertStatus(404);
        }
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     * @dataProvider showEditDestroyProvider
     */
    public function testEdit(string $idCas, bool $succes)
    {
        $enseignant = factory(Enseignant::class)->create();
        $id;
        switch($idCas)
        {
            case 'id_valide':
                $id = $enseignant->id;
            break;

            case 'id_numerique':
                $id = "$enseignant->id";
            break;

            case 'id_invalide':
                $id = -1;
            break;
        }
        $response = $this->get(route('enseignants.edit', $id));
        if($succes)
        {
            $response->assertOk()
            ->assertViewIs('enseignant.form')
            ->assertSee(EnseignantController::TITRE_EDIT);

            foreach($this->attributs as $attribut)
            {
                $response->assertSee($enseignant[$attribut]);
            }
        }
        else
        {
            $response->assertStatus(404);
        }
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     * @dataProvider updateProvider
     */
    public function testUpdate($clefModifiee, $nouvelleValeur)
    {
        $enseignantSource = factory(Enseignant::class)->create();
        $enseignantSource[$clefModifiee] = $nouvelleValeur;
        
        // Mise a jour et redirection OK
        $response = $this->from(route('enseignants.edit', $enseignantSource->id))
        ->patch(route('enseignants.update', $enseignantSource->id), $enseignantSource->toArray())
        ->assertRedirect(route('enseignants.index'));

        // Verification de la MAJ
        $enseignantMaj = Enseignant::find($enseignantSource->id);
        $this->assertEquals($enseignantSource->id, $enseignantMaj->id);
        foreach($this->attributs as $attribut)
        {
            $this->assertEquals($enseignantSource[$attribut], $enseignantMaj[$attribut]);
        }
    }

    public function updateProvider()
    {
        return [
            'Nom valide'         => [Enseignant::COL_NOM, 'nouveau'],
            'Prenom valide'      => [Enseignant::COL_PRENOM, 'nouveau'],
            'Mail valide'        => [Enseignant::COL_EMAIL, 'nouveau@example.com'],
            'Option valide'      => [Enseignant::COL_RESPONSABLE_OPTION_ID, 1],
            'Departement valide' => [Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID, 1],
        ];
    }

    /**
     * @depends testValiderModele
     * @dataProvider showEditDestroyProvider
     */
    public function testDestroy(string $idCas, bool $succes)
    {
        $enseignant = factory(Enseignant::class)->create();
        $id;
        switch($idCas)
        {
            case 'id_valide':
                $id = $enseignant->id;
            break;

            case 'id_numerique':
                $id = "$enseignant->id";
            break;

            case 'id_invalide':
                $id = -1;
            break;
        }
        $response = $this->from(route('enseignants.index'))
        ->delete(route('enseignants.destroy', $id));

        if($succes) // L'enseignant est supprime
        {
            $response->assertOk();
            $this->assertNull(Enseignant::find($id));
        }
        else // L'enseignent existe toujours
        {
            $response->assertStatus(404);
            $this->assertNotNull(Enseignant::find($enseignant->id));
        }
    }

    public function showEditDestroyProvider()
    {
        return [
            'Id valide'    => ['id_valide', TRUE],
            'Id numerique' => ['id_numerique', TRUE],
            'Id invalide'  => ['id_invalide', FALSE]
        ];
    }
}