<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Http\Controllers\Enseignant\ReferentController;
use App\Traits\TestAuthentification;

class ReferentControllerTest extends TestCase
{
    use TestAuthentification;

    /* ------------------------------------------------------------------
     *           AUXILIAIRES : tests de controle d'acces
     * ------------------------------------------------------------------
     */
    /**
     * Permet de facilement tester les differentes routes
     */
    public function controleAccesProvider()
    {
        // [string $route]
        return [
            'Index'            => ['referents.index', []],
            'Mes affectations' => ['referents.affectations', []],
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
        ->assertDontSee(route('responsables.affectations.create'))
        ->assertDontSee(route('responsables.affectations.index'));
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
