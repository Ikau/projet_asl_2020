<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\User;
use App\Modeles\Contact;
use App\Modeles\Enseignant;
use App\Modeles\Privilege;
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
        // Routages echecs
        $this->indexNonAuth();
        $this->indexNonEnseignant();
        $this->indexEnseignantNonAutorise();

        // Creation d'un enseignant permis
        $enseignant = factory(Enseignant::class)->create();
        
        // Creation de l'utilisteur associe
        $user                  = factory(User::class)->make();
        $user[User::COL_EMAIL] = $enseignant[Enseignant::COL_EMAIL];
        $user->userable()->associate($enseignant);
        $user->save();
        
        // Ajout des droits
        $privilegeReferent = Privilege::where(Privilege::COL_INTITULE, '=', 'Referent')->first();
        $user->privileges()->attach($privilegeReferent);
        $user->save();
        
        // Routage OK
        $this->actingAs($user)
        ->from('/')
        ->get(route('referents.index'))
        ->assertOk()
        ->assertViewIs('enseignant.commun.index')
        ->assertSee(ReferentController::TITRE_INDEX);
    }

    private function indexNonAuth()
    {
        $this->assertGuest()
        ->from('/')
        ->get(route('referents.index'))
        ->assertRedirect(route('login'));
    }

    private function indexNonEnseignant()
    {
        // Creation d'un utilisateur aleatoire
        $contact = factory(Contact::class)->create();
        $user    = factory(User::class)->make();
        $user->userable()->associate($contact);
        $user->save();

        // Routage echec
        $this->actingAs($user)
        ->from('/')
        ->get(route('referents.index'))
        ->assertStatus(403);
    }

    private function indexEnseignantNonAutorise()
    {
        // Creation d'un enseignant aleatoire
        $enseignant = factory(Enseignant::class)->create();
        $user       = factory(User::class)->make();
        $user->userable()->associate($enseignant);
        $user->privileges()->detach();
        $user->save();

        // Route echec
        $this->actingAs($user)
        ->from('/')
        ->get(route('referents.index'))
        ->assertStatus(403);
    }
}