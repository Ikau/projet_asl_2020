<?php

namespace Tests\Feature\CRUD;

use App\Facade\FicheFacade;
use App\Facade\UserFacade;
use App\Http\Controllers\Enseignant\ResponsableController;
use App\Modeles\Enseignant;
use App\Modeles\Stage;
use App\Traits\TestAuthentification;
use Tests\TestCase;

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
    public function controleGetAccesProvider()
    {
        // [string $route]
        return [
            'Liste affectations'      => ['responsables.affectations.index', []],
            'Form stage/affectations' => ['responsables.affectations.create', []],
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
        $this->actingAs($user)
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
        // Creation d'un enseignant responsable d'option
        $user = $this->creerUserRoleEnseignant();
        $this->ajouteRoleResponsableOption($user);

        // Routage OK
        $response = $this->actingAs($user)
            ->followingRedirects()
            ->from('/')
            ->get(route('responsables.affectations.index'))
            ->assertOk()
            ->assertViewIs('enseignant.responsable.affectations')
            ->assertSee(ResponsableController::TITRE_INDEX_AFFECTATION);

        // Integrite des colonnes
        $entetes = [
            'Nom stagiaire',
            'Prenom stagiaire',
            'Annee',
            'Promotion',
            'Option',
            'Etat de l\'affectation',
            'Etat du stage',
            'Referent',
            'Entreprise',
            'Lieu'
        ];
        foreach($entetes as $entete)
        {
            $response->assertSee(e($entete));
        }
    }

    public function testPostValiderAffectationOk()
    {
        // TODO
    }

    public function testPostValiderAffectationEchec()
    {
        // Nouvelle affectation
        $stage = factory(Stage::class)->create();
        FicheFacade::creerFiches($stage->id);

        // Non connecte
        $this->assertGuest()
            ->from('/')
            ->post(route('responsables.affectations.valider', $stage->id))
            ->assertRedirect(route('login'));

        // Non Responsable
        $user = $this->creerUserRoleEnseignant();
        $this->actingAs($user)
            ->from('/')
            ->post(route('responsables.affectations.valider', $stage->id))
            ->assertStatus(403);

        // Mauvais responsable
        $user = $this->creerUserRoleEnseignant();
        $user->identite->fill([
            Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID => null,
            Enseignant::COL_RESPONSABLE_OPTION_ID      => null
        ])->save();
        $this->actingAs($user)
            ->from('/')
            ->post(route('responsables.affectations.valider', $stage->id))
            ->assertStatus(403);

        // Stage inexistant

        // Non habilite

        // Stage sans referent
    }

}
