<?php

namespace Tests\Feature\CRUD;

use App\Facade\FicheFacade;
use App\Facade\PermissionFacade;
use App\Facade\UserFacade;
use App\Http\Controllers\Enseignant\ResponsableController;
use App\Modeles\Departement;
use App\Modeles\Enseignant;
use App\Modeles\Option;
use App\Modeles\Stage;
use App\Traits\TestAuthentification;
use App\User;
use Illuminate\Support\Facades\DB;
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

        // Le stage a bien un referent
        $referent = factory(Enseignant::class)->create();
        UserFacade::creerDepuisEnseignant($referent->id, 'azerty');

        $stage->referent()->dissociate();
        $stage->referent()->associate($referent);
        $stage->save();

        // Creation d'un responsable pour tester la validation
        $user = $this->creerUserRoleEnseignant();

        // Ajout des roles pour les Gates
        $this->ajouteRoleResponsableDepartement($user);
        $this->ajouteRoleResponsableOption($user);

        // Le responsable l'est pour l'option et le departement
        PermissionFacade::remplaceResponsableDepartement($stage->etudiant->departement->intitule, $user->identite);
        PermissionFacade::remplaceResponsableOption($stage->etudiant->option->intitule, $user->identite);

        // Routage ok
        $this->actingAs($user)
            ->followingRedirects()
            ->from(route('stages.show', $stage->id))
            ->post(route('responsables.affectations.valider', $stage->id))
            ->assertSee(e(ResponsableController::MESSAGE_AFFECTAATION_VALIDEE));
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
        $this->ajouteRoleResponsableDepartement($user);
        $this->ajouteRoleResponsableOption($user);

        $this->actingAs($user)
            ->followingRedirects()
            ->from('/')
            ->post(route('responsables.affectations.valider', -1))
            ->assertSee(ResponsableController::MESSAGE_AFFECTATION_INEXISTANTE);

        // Mauvais responsable : on va supprimer tous les responsables
        foreach(Option::getValeurs() as $intituleOption)
        {
            PermissionFacade::supprimeResponsableOption($intituleOption);
        }
        foreach(Departement::getValeurs() as $intituleDepartement)
        {
            PermissionFacade::supprimeResponsableDepartement($intituleDepartement);
        }

        $user->refresh();
        $this->actingAs($user)
            ->followingRedirects()
            ->from(route('stages.show', $stage->id))
            ->post(route('responsables.affectations.valider', $stage->id))
            ->assertSee(e(ResponsableController::MESSAGE_AFFECTATION_NON_RESPONSABLE));

        // Stage sans referent
        $stage->referent()->dissociate();
        $stage->save();

        $intituleDepartement = $stage->etudiant->departement->intitule;
        $intituleOption      = $stage->etudiant->option->intitule;
        PermissionFacade::remplaceResponsableDepartement($intituleDepartement, $user->identite);
        PermissionFacade::remplaceResponsableOption($intituleOption, $user->identite);

        $user->refresh();
        $this->actingAs($user)
            ->followingRedirects()
            ->from(route('stages.show', $stage->id))
            ->post(route('responsables.affectations.valider', $stage->id))
            ->assertSee(e(ResponsableController::MESSAGE_AFFECTATION_AUCUN_REFERENT));
    }

}
