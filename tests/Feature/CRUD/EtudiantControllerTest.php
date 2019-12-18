<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Modeles\Etudiant;
use App\Http\Controllers\CRUD\EtudiantController;
use App\Utils\Constantes;

class EtudiantControllerTest extends TestCase
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
        $etudiant                = factory(Etudiant::class)->make();
        $etudiant['test']        = 'normaliseInputsOptionnels';
        $etudiant[$clefModifiee] = $nouvelleValeur;

        $response = $this->followingRedirects()
        ->from(route('etudiants.tests'))
        ->post(route('etudiants.tests'), $etudiant->toArray())
        ->assertOk(); // Si les inputs optionnels sont null, 404 est renvoye
    }
    
    public function normaliseOptionnelsProvider()
    {
        //[string $clefModifiee, $nouvelleValeur]
        return [
            'Mobilite null'   => [Etudiant::COL_MOBILITE, null],
            'Mobilite on'     => [Etudiant::COL_MOBILITE, 'on']
        ];
    }

    /**
     * @depends testNormaliseOptionnels
     * @dataProvider validerFormProvider
     */
    public function testValiderForm(bool $possedeErreur, string $clefModifiee, $nouvelleValeur)
    {
        $etudiant                = factory(Etudiant::class)->make();
        $etudiant['test']        = 'validerForm';
        $etudiant[$clefModifiee] = $nouvelleValeur;

        $response = $this->from(route('etudiants.create'))
        ->post(route('etudiants.tests'), $etudiant->toArray());

        if($possedeErreur)
        {
            $response->assertSessionHasErrors($clefModifiee)
            ->assertRedirect(route('etudiants.create'));
        }
        else 
        {
            $response->assertSessionDoesntHaveErrors();
        }

    }

    public function validerFormProvider()
    {
        //[bool $possedeErreur, string $clefModifiee, $nouvelleValeur]
        return [
            // Succes
            'Nom valide'         => [FALSE, Etudiant::COL_NOM, 'nom'],
            'Prenom valide'      => [FALSE, Etudiant::COL_PRENOM, 'prenom'],
            'Email valide'       => [FALSE, Etudiant::COL_EMAIL, 'valide@email.com'],
            'Annee valide'       => [FALSE, Etudiant::COL_ANNEE, 4],
            'Departement valide' => [FALSE, Etudiant::COL_DEPARTEMENT_ID, 1],
            'Option valide'      => [FALSE, Etudiant::COL_OPTION_ID, 1],

            'Mobilite on'        => [FALSE, Etudiant::COL_MOBILITE, 'on'],
            'Mobilite null'      => [FALSE, Etudiant::COL_MOBILITE, null],
            'Mobilite vide'      => [FALSE, Etudiant::COL_MOBILITE, ''],
            'Mobilite bool'      => [FALSE, Etudiant::COL_MOBILITE, FALSE],
            'Mobilite 1'         => [FALSE, Etudiant::COL_MOBILITE, 1],
            'Mobilite 0'         => [FALSE, Etudiant::COL_MOBILITE, 0],
            
            // Echecs
            'Nom null'             => [TRUE, Etudiant::COL_NOM, null],
            'Prenom null'          => [TRUE, Etudiant::COL_PRENOM, null],
            'Email null'           => [TRUE, Etudiant::COL_EMAIL, null],
            'Annee null'           => [TRUE, Etudiant::COL_ANNEE, null],
            'Departement null'     => [TRUE, Etudiant::COL_DEPARTEMENT_ID, null],
            'Option null'          => [TRUE, Etudiant::COL_OPTION_ID, null],

            'Nom invalide'         => [TRUE, Etudiant::COL_NOM, 42],
            'Prenom invalide'      => [TRUE, Etudiant::COL_PRENOM, 42],
            'Email invalide'       => [TRUE, Etudiant::COL_EMAIL, 'invalide'],
            'Annee invalide'       => [TRUE, Etudiant::COL_ANNEE, '-1'],
            'Mobilite invalide'    => [TRUE, Etudiant::COL_MOBILITE, -1],
            'Departement invalide' => [TRUE, Etudiant::COL_DEPARTEMENT_ID, -1],
            'Option invalide'      => [TRUE, Etudiant::COL_OPTION_ID, -1],
        ];
    }

    /**
     * @dataProvider validerModeleProvider
     */
    public function testValiderModele(int $idCase, int $statutAttendu)
    {
        $etudiant = factory(Etudiant::class)->create();
        $id;
        switch($idCase)
        {
            case 0: 
                $id = $etudiant->id; 
            break;

            case 1: 
                $id = "$etudiant->id"; 
            break;

            case 2: 
                $id = -1; 
            break;

            case 3: 
                $id = null; 
            break;
        }

        $response = $this->followingRedirects()
        ->from(route('etudiants.tests'))
        ->post(route('etudiants.tests'), [
            'test' => 'validerModele',
            'id'   => $id
        ])
        ->assertStatus($statutAttendu);
    }

    public function validerModeleProvider()
    {
        // [int $idCas, int $statutAttendu]
        return [
            'Id valide'    => [0, 200],
            'Id numerique' => [1, 200],
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
        $response = $this->get(route('etudiants.index'))
        ->assertOK()
        ->assertViewIs('etudiant.index')
        ->assertSee(EtudiantController::TITRE_INDEX);

        foreach($this->getAttributsModele() as $attribut)
        {
            $response->assertSee("<td>$attribut</td>");
        }
    }

    public function testCreate()
    {
        $response = $this->get(route('etudiants.create'))
        ->assertOK()
        ->assertViewIs('etudiant.form')
        ->assertSee(EtudiantController::TITRE_CREATE);

        foreach($this->getAttributsModele() as $attribut)
        {
            if($attribut !== 'id') 
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
        $etudiantSource = factory(Etudiant::class)->make();

        // Verification redirection
        $response = $this->followingRedirects()
        ->from(route('etudiants.create'))
        ->post(route('etudiants.store'), $etudiantSource->toArray())
        ->assertViewIs('etudiant.index');

        // Clause where
        $attributs = $this->getAttributsModele();

        $arrayWhere = [];
        foreach($attributs as $a)
        {
            if('id' !== $a)
            {
                $arrayWhere[] = [$a, '=', $etudiantSource[$a]];
            }
        }

        // Verification sauvegarde
        $etudiantTest = Etudiant::where($arrayWhere)->first();
        $this->assertNotNull($etudiantTest);
        foreach($attributs as $a)
        {
            if('id' !== $a)
            {
                $this->assertEquals($etudiantTest[$a], $etudiantSource[$a]);
            }
        }
    }

    /**
     * @depends testValiderModele
     */
    public function testShow()
    {
        $etudiant = factory(Etudiant::class)->create();
        // Verification redirection
        $response = $this->from(route('etudiants.tests'))
        ->get(route('etudiants.show', $etudiant->id))
        ->assertOk()
        ->assertViewIs('etudiant.show')
        ->assertSee(EtudiantController::TITRE_SHOW);

        // Verification donnees
        foreach($this->getAttributsModele() as $a)
        {
            $response->assertSee($etudiant[$a]);
        }
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     */
    public function testEdit()
    {
        $etudiant = factory(Etudiant::class)->create();

        $response = $this->from(route('etudiants.tests'))
        ->get(route('etudiants.edit', $etudiant->id))
        ->assertOk()
        ->assertViewIs('etudiant.form')
        ->assertSee(EtudiantController::TITRE_EDIT);

        foreach($this->getAttributsModele() as $a)
        {
            $response->assertSee($a);
        }
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     * @dataProvider updateProvider
     */
    public function testUpdate(string $clefModifiee, $nouvelleValeur, $boolAttendu)
    {
        $etudiant                = factory(Etudiant::class)->create();
        $etudiant[$clefModifiee] = $nouvelleValeur;

        $response = $this->from(route('etudiants.tests'))
        ->patch(route('etudiants.update', $etudiant->id), $etudiant->toArray())
        ->assertRedirect(route('etudiants.index'));

        // Redefinition du champ 'mobilite' par un boolean
        if(null !== $boolAttendu)
       {
           $etudiant->mobilite = $boolAttendu;
       } 
        
        $etudiantTest = Etudiant::find($etudiant->id);
        foreach($this->getAttributsModele() as $a)
        {
            $this->assertEquals($etudiant[$a], $etudiantTest[$a]);
        }
    }

    public function updateProvider()
    {
        //[string $clefModifiee, $nouvelleValeur, bool $boolAttendu]
        return [
            // Sucess
            'Nom valide'         => [Etudiant::COL_NOM, 'valide', null],
            'Prenom valide'      => [Etudiant::COL_PRENOM, 'valide', null],
            'Email valide'       => [Etudiant::COL_EMAIL, 'valide@example.com', null],
            'Annee valide'       => [Etudiant::COL_ANNEE, 4, null],
            'Departement valide' => [Etudiant::COL_DEPARTEMENT_ID, 1, null],
            'Option valide'      => [Etudiant::COL_OPTION_ID, 1, null],

            'Mobilite on'        => [Etudiant::COL_MOBILITE, 'on', TRUE],
            'Mobilite null'      => [Etudiant::COL_MOBILITE, null, FALSE],
            'Mobilite vide'      => [Etudiant::COL_MOBILITE, '', FALSE],
        ];
    }

    /**
     * @depends testValiderModele
     */
    public function testDestroy()
    {
        $etudiant = factory(Etudiant::class)->create();

        $response = $this->from(route('etudiants.index'))
        ->delete(route('etudiants.destroy', $etudiant->id))
        ->assertRedirect(route('etudiants.index'));

        $etudiantTest = Etudiant::find($etudiant->id);
        $this->assertNull($etudiantTest);
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
        return Schema::getColumnListing(Etudiant::NOM_TABLE);
    }
}