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
        // Nouvelle affectation
        $stage = factory(Stage::class)->create();
        FicheFacade::creerFiches($stage->id);

        // On ajoute les bons droits
        $user  = $this->creerUserRoleEnseignant();
        $this->ajouteRoleResponsableDepartement($user);
        $this->ajouteRoleResponsableOption($user);

        $idDpt = $stage->etudiant->departement->id;
        $idOpt = $stage->etudiant->option->id;
        $user->identite->departement_id = $idDpt;
        $user->identite->option_id      = $idOpt;

        $stage->referent()->dissociate();
        $stage->referent()->associate($user->identite);
        $stage->save();


        // Routeage ok
        $this->actingAs($user)
            ->followingRedirects()
            ->from(route('stages.show', $stage->id))
            ->post(route('responsables.affectations.valider', $stage->id))
            ->assertSee(e(ResponsableController::MESSAGE_AFFECTATION_AJOUTEE));

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

        // Stage inexistant
        $user = $this->creerUserRoleEnseignant();
        $this->ajouteRoleResponsableDepartement($user);
        $this->actingAs($user)
            ->followingRedirects()
            ->from('/')
            ->post(route('responsables.affectations.valider', -1))
            ->assertSee(ResponsableController::MESSAGE_AFFECTATION_INEXISTANTE);


        // Mauvais responsable
        $user = $this->creerUserRoleEnseignant();
        $this->ajouteRoleResponsableDepartement($user);
        $user->identite[Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID] = null;
        $user->identite[Enseignant::COL_RESPONSABLE_OPTION_ID]      = null;
        $this->actingAs($user)
            ->followingRedirects()
            ->from(route('stages.show', $stage->id))
            ->post(route('responsables.affectations.valider', $stage->id))
            ->assertSee(e(ResponsableController::MESSAGE_AFFECTATION_NON_ROLE));

        // Stage sans referent
        $stage->referent()->dissociate();
        $stage->save();

        $user = $this->creerUserRoleEnseignant();
        $this->ajouteRoleResponsableDepartement($user);
        $this->ajouteRoleResponsableOption($user);

        $idDpt = $stage->etudiant->departement->id;
        $idOpt = $stage->etudiant->option->id;
        $user->identite->departement_id = $idDpt;
        $user->identite->option_id      = $idOpt;

        $this->actingAs($user)
            ->followingRedirects()
            ->from(route('stages.show', $stage->id))
            ->post(route('responsables.affectations.valider', $stage->id))
            ->assertSee(e(ResponsableController::MESSAGE_AFFECTATION_AUCUN_REFERENT));

    }

}
