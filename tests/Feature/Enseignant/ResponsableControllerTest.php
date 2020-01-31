<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\User;

use App\Modeles\Contact;
use App\Modeles\Enseignant;
use App\Modeles\Role;

use App\Http\Controllers\Enseignant\ResponsableController;

use App\Utils\Constantes;

class ResponsableControllerTest extends TestCase
{
    // Rollback les modifications de la BDD a la fin des tests
    use RefreshDatabase;

    /* ------------------------------------------------------------------
     *           AUXILIAIRES : tests de controle d'acces
     * ------------------------------------------------------------------
     */
    /**
     * Un utilisateur non authentifie doit etre renvoye a la page de login
     * 
     * @dataProvider controleAccesProvider
     */
    public function testNonAuth(string $uriRoute)
    {
        $this->assertGuest()
        ->from('/')
        ->get(route($uriRoute))
        ->assertRedirect(route('login'));
    }

    /**
     * Un utilisateur qui n'est pas de la classe App\Modeles\Enseignant n'est pas autorise
     * 
     * @dataProvider controleAccesProvider
     */
    public function testNonTypeEnseignant(string $uriRoute)
    {
        // Creation d'un utilisateur aleatoire
        $contact = factory(Contact::class)->create();
        $user    = factory(User::class)->make();
        $user->identite()->associate($contact);
        $user->save();

        // Routage echec
        $this->actingAs($user)
        ->from('/')
        ->get(route($uriRoute))
        ->assertStatus(403);
    }

    /**
     * Un utilisateur qui n'a pas le role App\Modeles\Role::VAL_ENSEIGNANT n'est pas autorise
     * 
     * @dataProvider controleAccesProvider
     */
    public function testNonRoleEnseignant(string $uriRoute)
    {
        // Creation d'un enseignant aleatoire
        $enseignant = factory(Enseignant::class)->create();
        $user       = factory(User::class)->make();
        $user->identite()->associate($enseignant);
        $user->save();

        // Route echec
        $this->actingAs($user)
        ->from('/')
        ->get(route($uriRoute))
        ->assertStatus(403);
    }

    /**
     * Permet de facilement tester les differentes routes
     */
    public function controleAccesProvider()
    {
        // [string $route]
        return [
            'Index'            => ['referents.index'],
            'Mes affectations' => ['referents.affectations'],
        ];
    }

    /* ------------------------------------------------------------------
     *                        Tests des routes
     * ------------------------------------------------------------------
     */
    public function testGetFormAffectation()
    {
        // Creation d'un enseignant responsable d'option
        $user = $this->creerUserRoleEnseignant();
        $this->ajouteRoleResponsableDepartement($user);

        // Routage OK
        $response = $this->actingAs($user)
        ->followingRedirects()
        ->from('/')
        ->get(route('responsables.affectations.get'))
        ->assertOk()
        ->assertViewIs('admin.modeles.stage.form')
        ->assertSee(ResponsableController::TITRE_GET_FORM_AFFECTATION);

        // Integrite du form
        // Redondate car deja verifiee dans StageControllerTest
    }


}