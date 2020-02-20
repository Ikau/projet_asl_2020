<?php

namespace Tests\Feature\CRUD;

use App\Http\Controllers\CRUD\PrivilegeController;
use App\Modeles\Contact;
use App\Modeles\Privilege;
use App\User;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

class PrivilegeControllerTest extends TestCase
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
        $privilege                = factory(Privilege::class)->make();
        $privilege['test']        = 'normaliseInputsOptionnels';
        $privilege[$clefModifiee] = $nouvelleValeur;

        $response = $this->from(route('privileges.tests'))
        ->post(route('privileges.tests'), $privilege->toArray())
        ->assertRedirect('/');
    }

    public function normaliseInputsOptionnelsProvider()
    {
        // [string $clefModifiee, $nouvelleValeur]
        return [
            'Privilege valide' => [Privilege::COL_INTITULE, 'intitule'],

            // Aucun argument optionnel pour l'instant
        ];
    }

    /**
     * @depends testNormaliseInputsOptionnels
     * @dataProvider validerFormProvider
     */
    public function testValiderForm(bool $possedeErreur, string $clefModifiee, $nouvelleValeur)
    {
        $privilege                = factory(Privilege::class)->make();
        $privilege['test']        = 'validerForm';
        $privilege[$clefModifiee] = $nouvelleValeur;

        $routeSource = route('privileges.tests');
        $response = $this->from($routeSource)
        ->post(route('privileges.tests'), $privilege->toArray());

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
            'Intitule valide' => [FALSE, Privilege::COL_INTITULE, 'intitule'],

            // Echec
            'Privilege invalide' => [TRUE, Privilege::COL_INTITULE, -1],
        ];
    }

    /**
     * @dataProvider validerModeleProvider
     */
    public function testValiderModele(int $idCase, int $statutAttendu)
    {
        $privilege = factory(Privilege::class)->create();
        $id;
        switch($idCase)
        {
            case 0:
                $id = $privilege->id;
            break;

            case 1:
                $id = "$privilege->id";
            break;

            case 2:
                $id = -1;
            break;

            case 3:
                $id = null;
            break;
        }

        $response = $this->followingRedirects()
        ->from(route('privileges.tests'))
        ->post(route('privileges.tests'), [
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
        // Verification de l'acces a la route
        $response = $this->from(route('privileges.tests'))
        ->get(route('privileges.index'))
        ->assertOk()
        ->assertViewIs('admin.modeles.privilege.index')
        ->assertSee(PrivilegeController::TITRE_INDEX);

        // Verification des attributs
        foreach($this->getAttributsModele() as $attribut)
        {
            $response->assertSee("<th>$attribut</th>");
        }
    }

    public function testCreate()
    {
        // Verification de la route
        $response = $this->from(route('privileges.tests'))
        ->get(route('privileges.create'))
        ->assertOk()
        ->assertViewIs('admin.modeles.privilege.form')
        ->assertSee(PrivilegeController::TITRE_CREATE);

        // Verification du form
        foreach($this->getAttributsModele() as $attribut)
        {
            if('id' !== $attribut)
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
        $privilege = factory(Privilege::class)->make();

        // Verification de la route
        $response = $this->from(route('privileges.tests'))
        ->post(route('privileges.store'), $privilege->toArray())
        ->assertRedirect(route('privileges.index'));

        // Verification de la creation
        $clauseWhere = [];
        foreach($this->getAttributsModele() as $attribut)
        {
            if('id' !== $attribut)
            {
                $clauseWhere[] = [$attribut, '=', $privilege[$attribut]];
            }
        }

        $privilegeTest = Privilege::where($clauseWhere)->first();
        $this->assertNotNull($privilegeTest);

        // Verification de l'integrite des donnees
        foreach($this->getAttributsModele() as $attribut)
        {
            if('id' !== $attribut)
            {
                $this->assertEquals($privilege[$attribut], $privilegeTest[$attribut]);
            }
        }
    }

    /**
     * @depends testValiderModele
     */
    public function testShow()
    {
        // Creation d'un privilege aleatoire
        $privilege = factory(Privilege::class)->create();

        // Verification de la route
        $response = $this->from(route('privileges.tests'))
        ->get(route('privileges.show', $privilege->id))
        ->assertViewIs('admin.modeles.privilege.show')
        ->assertSee(PrivilegeController::TITRE_SHOW);

        // Verification de l'integrite des donnees
        foreach($this->getAttributsModele() as $attribut)
        {
            $response->assertSee(e($privilege[$attribut]));
        }

        // Verification 404
        $this->from(route('privileges.tests'))
        ->get(route('privileges.show', -1))
        ->assertStatus(404);
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     */
    public function testEdit()
    {
        // Creation d'un privilege aleatoire
        $privilege = factory(Privilege::class)->create();

        // Verification de la route
        $response = $this->from(route('privileges.tests'))
        ->get(route('privileges.edit', $privilege->id))
        ->assertViewIs('admin.modeles.privilege.form')
        ->assertSee(PrivilegeController::TITRE_EDIT);

        // Integrite des donnees
        foreach($this->getAttributsModele() as $attribut)
        {
            if('id' !== $attribut)
            {
                $response->assertSee("name=\"$attribut\"")
                ->assertSee(e($privilege[$attribut]));
            }
        }

        // Verification 404
        $this->from(route('privileges.tests'))
        ->get(route('privileges.edit', -1))
        ->assertStatus(404);
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     * @dataProvider updateProvider
     */
    public function testUpdate(string $clefModifiee, $nouvelleValeur)
    {
        // Creation privilege aleatoire et modif
        $privilege                = factory(Privilege::class)->create();
        $privilege[$clefModifiee] = $nouvelleValeur;

        // Routage
        $response = $this->from(route('privileges.edit', $privilege->id))
        ->patch(route('privileges.update', $privilege->id), $privilege->toArray())
        ->assertRedirect(route('privileges.index'));

        // Verification update
        $clauseWhere = [];
        foreach($this->getAttributsModele() as $attribut)
        {
            if('id' !== $attribut)
            {
                $clauseWhere[] = [$attribut, '=', $privilege[$attribut]];
            }
        }

        $privilegeTest = Privilege::where($clauseWhere)->first();
        $this->assertNotNull($privilegeTest);
        foreach($this->getAttributsModele() as $attribut)
        {
            $this->assertEquals($privilege[$attribut], $privilegeTest[$attribut]);
        }
    }

    public function updateProvider()
    {
        // [string $clefModifiee, $nouvelleValeur]
        return [
            'Intitule valide' => [Privilege::COL_INTITULE, 'intitule']
        ];
    }

    /**
     * @depends testValiderModele
     */
    public function testDestroy()
    {
        // Creation privilege aleatoire avec utilisateurs
        $privilege = factory(Privilege::class)->create();

        for($i=0; $i<10; $i++)
        {
            // Creation d'un contact
            $contact = factory(Contact::class)->create();

            // Creation de l'utilisateur associe
            $user = factory(User::class)->make();
            $user->identite()->associate($contact);
            $user->save();
            $user->privileges()->attach($privilege->id);
        }

        // Routage
        $response = $this->from(route('privileges.tests'))
        ->delete(route('privileges.destroy', $privilege->id))
        ->assertRedirect(route('privileges.index'));

        // Verification suppression du privilege
        $privilegeTest = Privilege::find($privilege->id);
        $this->assertNull($privilegeTest);

        // Verification suppression table pivot
        $users = User::has('privileges')->get();
        foreach($users as $user)
        {
            $this->assertFalse($user->privileges->contains($privilege->id));
        }

        // Verification 404
        $this->from(route('privileges.tests'))
        ->delete(route('privileges.destroy', -1))
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
        return Schema::getColumnListing(Privilege::NOM_TABLE);
    }
}
