<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use App\User;
use App\Modeles\Enseignant;
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

        // Creation d'un enseignant
        $user->userable()->associate(factory(Enseignant::class)->create());

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
            'Email valide'   => [FALSE, User::COL_EMAIL, 'aucun@null.com'],

            // Echec
            'Email null'     => [TRUE, User::COL_EMAIL, null],
            'Email existant' => [TRUE, User::COL_EMAIL, 'admin@insa-cvl.fr'],
            'Email invalide' => [TRUE, User::COL_EMAIL, 'emailInvalide'],
        ];
    }

    /**
     * @dataProvider validerModeleProvider
     */
    public function testValiderModele(int $idCase, int $statutAttendu)
    {
        $user = factory(User::class)->make();

        // Creation d'un enseignant
        $user->userable()->associate(factory(Enseignant::class)->create());
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
        // Creation d'un enseignant aleatoire pour l'associer a un nouvel utilisateur
        $enseignant = factory(Enseignant::class)->create();

        // Routage
        $this->from(route('users.create'))
        ->post(route('users.store'), [User::COL_EMAIL => $enseignant[Enseignant::COL_EMAIL]])
        ->assertRedirect(route('users.index'));

        // Verification insertion
        $userTest = User::where(User::COL_EMAIL, '=', $enseignant[User::COL_EMAIL])->first();
        $this->assertNotNull($userTest);
        $this->assertEquals($enseignant[User::COL_EMAIL], $userTest[User::COL_EMAIL]);
    }

    /**
     * @depends testValiderModele
     */
    public function testShow()
    {
        // Creation d'un compte aleatoire
        $user = $this->creerUtilisateurAleatoire();

        // Routage
        $response = $this->from(route('users.tests'))
        ->get(route('users.show', $user->id))
        ->assertViewIs('admin.modeles.user.show')
        ->assertSee(e(UserController::TITRE_SHOW));

        // Integrite des donnees
        $userTest = User::where(User::COL_EMAIL, '=', $user[User::COL_EMAIL])->first();
        $this->assertNotNull($userTest);
        foreach($this->getAttributsModele() as $attribut)
        {
            if(User::COL_REMEMBER_TOKEN !== $attribut
            && User::COL_HASH_PASSWORD !== $attribut)
            {
                $response->assertSee(e($userTest[$attribut]));
            }
        }

        // Verification echec
        $this->from(route('users.tests'))
        ->get(route('users.show', -1))
        ->assertStatus(404);
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     */
    public function testEdit()
    {
        // Creation d'un utilisateur
        $user = $this->creerUtilisateurAleatoire();

        // Routage
        $response = $this->from(route('users.tests'))
        ->get(route('users.edit', $user->id))
        ->assertViewIs('admin.modeles.user.form')
        ->assertSee(UserController::TITRE_EDIT);

        // Integrite des donnees modifiables
        $response->assertSee($user[User::COL_EMAIL]);
    }

    /**
     * @depends testValiderForm
     * @depends testValiderModele
     */
    public function testUpdate()
    {
        // Creation d'un nouvel utilisateur
        $user = $this->creerUtilisateurAleatoire();
        
        // Creation d'un noucel email
        $nouvelEmail = factory(Enseignant::class)->create()->email;

        // Routage
        $this->from(route('users.tests'))
        ->patch(route('users.update', $user->id), [User::COL_EMAIL => $nouvelEmail])
        ->assertRedirect(route('users.index'));

        // Verification update
        $userTest = User::find($user->id);
        $this->assertNotNull($userTest);
        $this->assertEquals($nouvelEmail, $userTest[User::COL_EMAIL]);
        $this->assertNull($userTest[User::COL_EMAIL_VERIFIE_LE]);

        // Verification echec email
        $this->from(route('users.tests'))
        ->patch(route('users.update', -1))
        ->assertStatus(302)
        ->assertRedirect(route('users.tests'));

        // Verification echec Id
        $this->from(route('users.tests'))
        ->patch(route('users.update', -1), [User::COL_EMAIL => 'aucun@null.com'])
        ->assertStatus(404);
    }

    /**
     * @depends testValiderModele
     */
    public function testDestroy()
    {
        // Creation nouvel utilisateur
        $user = $this->creerUtilisateurAleatoire();

        // Routage
        $this->from(route('users.tests'))
        ->delete(route('users.destroy', $user->id))
        ->assertRedirect(route('users.index'));

        // Verification suppression
        $userTest = User::where(User::COL_EMAIL, '=', $user[User::COL_EMAIL])->first();
        $this->assertNull($userTest);

        // Verification id invalide
        $this->from(route('users.tests'))
        ->delete(route('users.destroy', -1))
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
        return Schema::getColumnListing(User::NOM_TABLE);
    }

    /**
     * Cree et renvoie un utilisateur cree aleatoirement.
     *
     * @return App\User Utilisateur aleatoirement cree
     */
    private function creerUtilisateurAleatoire()
    {
        // Creation d'un enseignant
        $enseignant = factory(Enseignant::class)->create();

        // Creation utilisateur
        $user = factory(User::class)->make();
        $user[User::COL_EMAIL] = $enseignant->email;
        $user->userable()->associate($enseignant);
        $user->save();

        return $user;
    }
}