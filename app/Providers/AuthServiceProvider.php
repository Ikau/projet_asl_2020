<?php

namespace App\Providers;

use App\Utils\Constantes;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

use App\Interfaces\Gates;

class AuthServiceProvider extends ServiceProvider implements Gates
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
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
        $this->enregistrerGatesReferent();
        $this->enregistrerGatesResponsable();
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
                return Response::deny('Seuls les enseignants peuvent acceder a cette partie du site.');
            }

            // Verification si role enseignant+ autorise
            if($user->estEnseignant()
            || $user->estResponsableOption()
            || $user->estResponsableDepartement())
            {
                return Response::allow();
            }
            else
            {
                return Response::deny('Votre compte enseignant n\'est pas autorise a cette partie du site.');
            }
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
                return Response::deny('Seuls les enseignants peuvent acceder a cette partie du site.');
            }

            // Verification si role responsable+ autorise
            if($user->estResponsableOption()
            || $user->estResponsableDepartement())
            {
                return Response::allow();
            }
            else
            {
                return Response::deny('Votre compte enseignant n\'est pas autorise a cette partie du site.');
            }
        });
    }
}
