<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

use App\Interfaces\Gates;
use App\Modeles\Privilege;
use App\Http\Controllers\Enseignant\ReferentController;

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
    }

    /**
     * Enregistre toutes les regles 'Gates' relatifs au controle d'acces pour l'espace.
     * 
     * @return void
     */
    public function enregistrerGatesReferent()
    {
        Gate::define(ReferentController::GATE_GET_ACCUEIL, function($user) {
            // Recuperation privilege referent
            $privilegeReferent = Privilege::where(Privilege::COL_INTITULE, '=', 'Referent')->first();

            return $user->privileges()->get()->contains($privilegeReferent)
                ? Response::allow()
                : Response::deny('Seuls les enseignants autorises peuvent acceder a cette partie du site.');
        });
    }
}
