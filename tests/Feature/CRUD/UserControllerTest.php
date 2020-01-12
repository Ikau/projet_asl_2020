<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use App\User;
use App\Modeles\Contact;
use App\Http\Controllers\CRUD\UserController;
use App\Utils\Constantes;


class UserControllerTest extends TestCase
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
        $user                = factory(User::class)->make();
        $user['test']        = 'normaliseInputsOptionnels';
        $user[$clefModifiee] = $nouvelleValeur;

        $this->from(route('users.tests'))
        ->post(route('users.tests'), $user->toArray())
        ->assertRedirect('/');
    }

    public function normaliseInputsOptionnelsProvider()
    {
        // [string $clefModifiee, $nouvelleValeur]
        return [
            'User valide' => [User::COL_EMAIL, 'email@valide.com']

            // Il n'y a pour l'instant pas de champs optionnels
        ];
    }

    /**
     * @depends testNormaliseInputsOptionnels
     * @dataProvider validerFormProvider
     */
    public function testValiderForm(bool $possedeErreur, string $clefModifiee, $nouvelleValeur)
    {
        $user                = factory(User::class)->make();
        $user['test']        = 'validerForm';
        $user[$clefModifiee] = $nouvelleValeur;

        // Creation d'un contact
        $user->userable()->associate(factory(Contact::class)->create());

        // Routage
        $routeSource = route('users.tests');
        $response = $this->from($routeSource)
        ->post(route('users.tests'), $user->toArray());

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
            'Email valide'    => [FALSE, User::COL_EMAIL, 'email@valide.com'],

            // Echec
            'Email null'    => [TRUE, User::COL_EMAIL, null],
            'Email invalide'    => [TRUE, User::COL_EMAIL, 'emailInvalide'],
        ];
    }

    /**
     * @dataProvider validerModeleProvider
     */
    public function testValiderModele(int $idCase, int $statutAttendu)
    {
        $user = factory(User::class)->make();

        // Creation d'un contact
        $user->userable()->associate(factory(Contact::class)->create());
        $user->save();

        $id;
        switch($idCase)
        {
            case 0: 
                $id = $user->id; 
            break;

            case 1: 
                $id = "$user->id"; 
            break;

            case 2: 
                $id = -1; 
            break;

            case 3: 
                $id = null; 
            break;
        }
        
        $response = $this->followingRedirects()
        ->from(route('users.tests'))
        ->post(route('users.tests'), [
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
        // Routage
        $response = $this->from(route('users.tests'))
        ->get(route('users.index'))
        ->assertViewIs('admin.modeles.user.index')
        ->assertSee(UserController::TITRE_INDEX);

        // Attributs
        foreach($this->getAttributsModele() as $attribut)
        {
            $response->assertSee($attribut);
        }

    }

    public function testCreate()
    {
        // Routage
        $response = $this->from(route('users.tests'))
        ->get(route('users.create'))
        ->assertViewIs('admin.modeles.user.form')
        ->assertSee(UserController::TITRE_CREATE);

        // Form
        $response->assertSee("name=\"email\"");
    }
    
    /**
     * @depends testValiderForm
     */
    public function testStore()
    {
        // Creation d'un contact aleatoire pour l'associer a un nouvel utilisateur
        $contact = factory(Contact::class)->create();

        // Routage
        $this->from(route('users.create'))
        ->post(route('users.store'), [User::COL_EMAIL => $contact[Contact::COL_EMAIL]])
        ->assertRedirect(route('users.index'));

        // Verification insertion
        $userTest = User::where(User::COL_EMAIL, '=', $contact[User::COL_EMAIL])->first();
        $this->assertNotNull($userTest);
        $this->assertEquals($contact[User::COL_EMAIL], $userTest[User::COL_EMAIL]);
        $this->assertEquals(FALSE, $userTest[User::COL_EMAIL_VERIFIE_LE]);
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
        return Schema::getColumnListing(User::NOM_TABLE);
    }
}