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
use App\Http\Controllers\Enseignant\ReferentController;
use App\Utils\Constantes;

class ReferentControllerTest extends TestCase
{
    // Rollback les modifications de la BDD a la fin des tests
    use RefreshDatabase;

    /* ------------------------------------------------------------------
     *                INDEX : Tableau de bord et accueil
     * ------------------------------------------------------------------
     */

     /**
      * Test de feature pour acceder a l'accueil de l'espace 'enseignant'
      */
    public function testIndex()
    {
        // Creation d'un enseignant permis
        $enseignant = factory(Enseignant::class)->create();
        
        // Creation de l'utilisteur associe
        $user = User::fromEnseignant($enseignant->id, 'azerty');
        
        // Ajout du role 'referent'
        $roleReferent = Role::where([Role::COL_INTITULE, '=', Role::VAL_ENSEIGNANT])->first();
        $user->roles()->associate($roleReferent);
        $user->save();
        
        // Routage OK
        $this->actingAs($user)
        ->from('/')
        ->get(route('referents.index'))
        ->assertOk()
        ->assertViewIs('enseignant.commun.index')
        ->assertSee(ReferentController::TITRE_INDEX);
    }

    /**
     * Echec de l'index si non authentifie
     */
    public function testIndexNonAuth()
    {
        $this->assertGuest()
        ->from('/')
        ->get(route('referents.index'))
        ->assertRedirect(route('login'));
    }

    /**
     * Echec de l'index si non enseignant
     */
    public function testIndexNonEnseignant()
    {
        // Creation d'un utilisateur aleatoire
        $contact = factory(Contact::class)->create();
        $user    = factory(User::class)->make();
        $user->identite()->associate($contact);
        $user->save();

        // Routage echec
        $this->actingAs($user)
        ->from('/')
        ->get(route('referents.index'))
        ->assertStatus(403);
    }

    /**
     * Echec de l'index si enseignant non autorisé
     */
    public function testIndexEnseignantNonAutorise()
    {
        // Creation d'un enseignant aleatoire
        $enseignant = factory(Enseignant::class)->create();
        $user       = factory(User::class)->make();
        $user->identite()->associate($enseignant);
        $user->save();

        // Route echec
        $this->actingAs($user)
        ->from('/')
        ->get(route('referents.index'))
        ->assertStatus(403);
    }
}