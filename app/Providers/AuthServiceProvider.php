<?php

namespace App\Providers;

use App\Interfaces\Gates;
use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Stage;
use App\Policies\FicheRapportPolicy;
use App\Policies\StagePolicy;
use App\Utils\Constantes;
use Illuminate\Auth\Access\Response;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider implements Gates
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        FicheRapport::class => FicheRapportPolicy::class,
        Stage::class        => StagePolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gates personnalises
        $this->enregistrerGatesAdminitrateur();
        $this->enregistrerGatesReferent();
        $this->enregistrerGatesResponsable();
        $this->enregistrerGatesScolarite();
    }

    /* ------------------------------------------------------------------
     *                       Overrides interface Gate
     * ------------------------------------------------------------------
     */

    /**
     * Enregistre toutes les regles 'Gates' relatives au controle d'acces des pages
     * pour le role 'administrateur'
     *
     * @return void
     */
    public function enregistrerGatesAdminitrateur()
    {
        Gate::define(Constantes::GATE_ROLE_ADMINISTRATEUR, function($user) {
            if( ! $user->estAdministrateur() )
            {
                return Response::deny("Seuls les administrateurs peuvent accéder à cette partie du site.");
            }

            return Response::allow();
        });
    }

    /**
     * Enregistre toutes les regles 'Gates' relatives au controle d'acces des pages
     * pour le role 'referent'
     *
     * @return void
     */
    public function enregistrerGatesReferent()
    {
        Gate::define(Constantes::GATE_ROLE_ENSEIGNANT, function($user) {
            if( ! $user->estEnseignant() )
            {
                return Response::deny('Seuls les enseignants peuvent accéder a cette partie du site.');
            }

            return Response::allow();
        });
    }

    /**
     * Enregistre toutes les regles 'Gates' relatives au controle d'acces des pages
     * pour le role 'responsable-option' ou 'responsable-departement'
     *
     * @return void
     */
    public function enregistrerGatesResponsable()
    {
        Gate::define(Constantes::GATE_ROLE_RESPONSABLE, function($user) {
            if( ! $user->estEnseignant() )
            {
                return Response::deny('Seuls les enseignants peuvent accéder a cette partie du site.');
            }

            // Verification si role responsable+ autorise
            if($user->estResponsableOption()
            || $user->estResponsableDepartement())
            {
                return Response::allow();
            }
            else
            {
                return Response::deny("Seuls les responsables d'option ou de département peuvent accéder à cette partie du site.");
            }
        });
    }

    /**
     * Enregistre toutes les regles 'Gates' relatives au controle d'acces des pages
     * pour le role 'scolarite'
     *
     * @return void
     */
    public function enregistrerGatesScolarite()
    {
        Gate::define(Constantes::GATE_ROLE_SCOLARITE, function($user) {
            if( ! $user->estScolariteINSA() )
            {
                return Response::deny("Seuls la scolarite de l'INSA peut accéder à cette partie du site.");
            }

            return Response::allow();
        });
    }
}
