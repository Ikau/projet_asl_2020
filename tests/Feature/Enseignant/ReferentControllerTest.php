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

    /**
     * Test de feature pour acceder a l'accueil de l'espace 'enseignant'
     */
    public function testIndex()
    {   
        // Creation d'un enseignant valide
        $user = $this->creerUserRoleEnseignant();

        // Routage OK
        $this->actingAs($user)
        ->from('/')
        ->get(route('referents.index'))
        ->assertOk()
        ->assertViewIs('enseignant.commun.index')
        ->assertSee(ReferentController::TITRE_INDEX)

        // Controle d'acces des actions
        ->assertSee(route('referents.affectations'))
        ->assertDontSee(route('responsables.affectations.get'));
    }

    /**
     * Test de feature pour acceder a la page des affections d'un enseignant
     */
    public function testAffectations()
    {
        // Creation d'un enseignant valide
        $user = $this->creerUserRoleEnseignant();

        // Routage OK
        $response = $this->actingAs($user)
        ->from('/')
        ->get(route('referents.affectations'))
        ->assertOk()
        ->assertViewIs('enseignant.commun.affectations')
        ->assertSee(ReferentController::TITRE_AFFECTATIONS);

        // Integrite des colonnes
        $entetes = [
            'Nom stagiaire',
            'Prenom stagiaire',
            'Annee',
            'Promotion',
            'Departement',
            'Sujet',
            'Entreprise',
            'Rapport',
            'Soutenance',
            'Synthese'
        ];

        foreach($entetes as $entete)
        {
            $response->assertSee($entete);
        }

        // Integrite des donnees

    }
}