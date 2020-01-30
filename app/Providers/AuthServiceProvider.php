<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;

use App\User;

use App\Interfaces\Gates;

use App\Modeles\Enseignant;
use App\Modeles\Privilege;
use App\Modeles\Role;

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
        Gate::define(ReferentController::GATE_ROLE_ENSEIGNANT, function($user) {
            // Verification si enseignant
            if(Enseignant::class !== $user[User::COL_POLY_MODELE_TYPE])
            {
                return Response::deny('Seuls les enseignants peuvent acceder a cette partie du site.');
            }

            // Verification si role autorise
            $roleEnseignant             = Role::where(Role::COL_INTITULE, '=', Role::VAL_ENSEIGNANT)->first();
            $roleResponsableDepartement = Role::where(Role::COL_INTITULE, '=', Role::VAL_RESP_DEPARTEMENT)->first();
            $roleResponsableOption      = Role::where(Role::COL_INTITULE, '=', Role::VAL_RESP_OPTION)->first();
            if($user->roles->contains($roleEnseignant)
            || $user->roles->contains($roleResponsableDepartement)
            || $user->roles->contains($roleResponsableOption))
            {
                return Response::allow();
            }
            else
            {
                return Response::deny('Votre compte enseignant n\'est pas autorise a cette partie du site.');
            }

            abort('404');
        });
    }
}
