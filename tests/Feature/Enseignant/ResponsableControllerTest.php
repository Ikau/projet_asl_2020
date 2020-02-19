<?php

namespace Tests\Feature\CRUD;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use App\Http\Controllers\Enseignant\ResponsableController;

use App\Traits\TestAuthentification;

class ResponsableControllerTest extends TestCase
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
            'Liste affectations'      => ['responsables.affectations.index', []],
            'Form stage/affectations' => ['responsables.affectations.create', []]
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
        ->get(route('responsables.affectations.create'))
        ->assertOk()
        ->assertViewIs('admin.modeles.stage.form')
        ->assertSee(ResponsableController::TITRE_GET_FORM_AFFECTATION);

        // Integrite du form
        // Redondate car deja verifiee dans StageControllerTest
    }

    public function testGetIndexAffectation()
    {

    }

    public function testPostValiderAffectation()
    {

    }

}
