<?php

namespace App\Traits;

use App\Modeles\Contact;
use App\Modeles\Enseignant;
use App\User;

trait TestAuthentification
{

    /* ------------------------------------------------------------------
     *           AUXILIAIRES : tests de controle d'acces
     * ------------------------------------------------------------------
     */
    /**
     * Un utilisateur non authentifie doit etre renvoye a la page de login
     *
     * @dataProvider controleAccesProvider
     */
    public function testNonAuth(string $uriRoute)
    {
        $this->assertGuest()
            ->from('/')
            ->get(route($uriRoute))
            ->assertRedirect(route('login'));
    }

    /**
     * Un utilisateur qui n'est pas de la classe App\Modeles\Enseignant n'est pas autorise
     *
     * @dataProvider controleAccesProvider
     */
    public function testNonTypeEnseignant(string $uriRoute)
    {
        // Creation d'un utilisateur aleatoire
        $contact = factory(Contact::class)->create();
        $user    = factory(User::class)->make();
        $user->identite()->associate($contact);
        $user->save();

        // Routage echec
        $this->actingAs($user)
            ->from('/')
            ->get(route($uriRoute))
            ->assertStatus(403);
    }

    /**
     * Un utilisateur qui n'a pas le role App\Modeles\Role::VAL_ENSEIGNANT n'est pas autorise
     *
     * @dataProvider controleAccesProvider
     */
    public function testNonRoleEnseignant(string $uriRoute)
    {
        // Creation d'un enseignant aleatoire
        $enseignant = factory(Enseignant::class)->create();
        $user       = factory(User::class)->make();
        $user->identite()->associate($enseignant);
        $user->save();

        // Route echec
        $this->actingAs($user)
            ->from('/')
            ->get(route($uriRoute))
            ->assertStatus(403);
    }
}
