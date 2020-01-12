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
            'Password valide' => [FALSE, User::COL_HASH_PASSWORD, 'password'],

            // Echec
            'Email null'    => [TRUE, User::COL_EMAIL, null],
            'Password null' => [TRUE, User::COL_HASH_PASSWORD, null],

            'Email invalide'    => [TRUE, User::COL_EMAIL, 'emailInvalide'],
            'Password invalide' => [TRUE, User::COL_HASH_PASSWORD, -1],
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
        $this->assertTrue(TRUE);
    }

    public function testCreate()
    {
        $this->assertTrue(TRUE);
    }
    
    /**
     * @depends testValiderForm
     */
    public function testStore()
    {
        $this->assertTrue(TRUE);
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
        // return Schema::getColumnListing(Template::NOM_TABLE);
    }
}