<?php

namespace Tests\Feature\Scolarite;

use App\Facade\UserFacade;
use App\Http\Controllers\Scolarite\ScolariteController;
use App\Modeles\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ScolariteControllerTest extends TestCase
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
     * @dataProvider controleGetAccesProvider
     */
    public function testNonAuth(string $uriRoute)
    {
        $this->assertGuest()
            ->from('/')
            ->get(route($uriRoute))
            ->assertRedirect(route('login'));
    }

    /**
     * Un utilisateur authentifie sans le role 'scolarite' n'a pas acces au routes
     *
     * @dataProvider controleGetAccesProvider
     */
    public function testNonScolarite(string $uriRoute)
    {
        // Creation d'un utilisateur aleatoire n'ayant pas le role
        $contact = factory(Contact::class)->create();
        $user    = UserFacade::creerDepuisContact($contact->id, 'azerty');

        $this->actingAs($user)
            ->from('/')
            ->get(route($uriRoute))
            ->assertStatus(403);
    }

    /**
     * Permet de facilement tester les differentes routes
     */
    public function controleGetAccesProvider()
    {
        // [string $route]
        return [
            'Index'              => ['scolarite.index'],
            'Liste affectations' => ['scolarite.affectations'],
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
        // Creation d'un utilisateur INSA valide
        $user = $this->creerUserScolarite();

        // Routage OK
        $this->actingAs($user)
            ->from('/')
            ->get(route('scolarite.index'))
            ->assertOk()
            ->assertViewIs('scolarite.index')
            ->assertSee(ScolariteController::VAL_TITRE_INDEX)

            // Integrite des actions
            ->assertSee(route('scolarite.affectations'));
    }

    /**
     * Test de feature pour acceder a la page des affections d'un enseignant
     */
    public function testAffectations()
    {
        // Creation d'un utilisateur INSA valide
        $user = $this->creerUserScolarite();

        // Routage
        $response = $this->actingAs($user)
            ->from('/')
            ->get(route('scolarite.affectations'))
            ->assertOk()
            ->assertViewIs('scolarite.affectations');

        // Integrite de la page
        $entetes = [
            'Année',
            'Stagiaire',
            'Promotion',
            'Referent',
            'Entreprise',
            'Rapport',
            'Soutenance',
            'Synthese'
        ];

        foreach($entetes as $entete)
        {
            $response->assertSee($entete);
        }

    }
}
