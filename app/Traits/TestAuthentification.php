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
     * @dataProvider controleGetAccesProvider
     */
    public function testGetNonAuth(string $uriRoute, array $args)
    {
        $this->assertGuest()
            ->from('/')
            ->get(route($uriRoute, $args))
            ->assertRedirect(route('login'));
    }

    /**
     * Un utilisateur qui n'est pas de la classe App\Modeles\Enseignant n'est pas autorise
     *
     * @dataProvider controleGetAccesProvider
     */
    public function testGetNonTypeEnseignant(string $uriRoute, array $args)
    {
        // Creation d'un utilisateur aleatoire
        $contact = factory(Contact::class)->create();
        $user    = factory(User::class)->make();
        $user->identite()->associate($contact);
        $user->save();

        // Routage echec
        $this->actingAs($user)
            ->from('/')
            ->get(route($uriRoute, $args))
            ->assertStatus(403);
    }

    /**
     * Un utilisateur qui n'a pas le role App\Modeles\Role::VAL_ENSEIGNANT n'est pas autorise
     *
     * @dataProvider controleGetAccesProvider
     */
    public function testGetNonRoleEnseignant(string $uriRoute, array $args)
    {
        // Creation d'un enseignant aleatoire
        $enseignant = factory(Enseignant::class)->create();
        $user       = factory(User::class)->make();
        $user->identite()->associate($enseignant);
        $user->save();

        // Route echec
        $this->actingAs($user)
            ->from('/')
            ->get(route($uriRoute, $args))
            ->assertStatus(403);
    }
}
