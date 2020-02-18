<?php

namespace Tests\Unit\Modeles;

use App\Facade\UserFacade;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

use App\User;
use App\Modeles\Contact;
use App\Modeles\Enseignant;
use App\Utils\Constantes;

class UserTest extends TestCase
{
    // Rollback les modifications de la BDD a la fin des tests
    use RefreshDatabase;

    /* ====================================================================
     *                       CONSTRUCTEURS STATIQUES
     * ====================================================================
     */

    public function testFromContact()
    {
        // Definition
        $contact    = factory(Contact::class)->create();
        $motDePasse = 'azerty';
        $user       = UserFacade::creerDepuisContact($contact->id, $motDePasse);
        $this->assertNotNull($user);

        // Verification existence
        $userTest = User::where(User::COL_EMAIL, '=', $contact[Contact::COL_EMAIL])->first();
        $this->assertNotNull($userTest);

        // Integrite des donnees
        $contactTest = $userTest->identite;
        $this->assertNotNull($contactTest);
        $this->assertEquals($contact->id, $contactTest->id);
        $this->assertEquals($contact[Contact::COL_EMAIL], $userTest[User::COL_EMAIL]);
        $this->assertEquals($user[User::COL_EMAIL], $userTest[User::COL_EMAIL]);
        Hash::check($motDePasse, $userTest[User::COL_HASH_PASSWORD]);
    }

    public function testFromEnseignant()
    {
        // Definition
        $enseignant = factory(Enseignant::class)->create();
        $motDePasse = 'azerty';
        $user       = UserFacade::creerDepuisEnseignant($enseignant->id, $motDePasse);
        $this->assertNotNull($user);

        // Verification existence
        $userTest = User::where(User::COL_EMAIL, '=', $enseignant[Enseignant::COL_EMAIL])->first();
        $this->assertNotNull($userTest->email);

        // Integrite des donneess
        $enseignantTest = $userTest->identite;
        $this->assertNotNull($enseignantTest);
        $this->assertEquals($enseignant->id, $enseignantTest->id);
        $this->assertEquals($enseignant[Enseignant::COL_EMAIL], $userTest[User::COL_EMAIL]);
        $this->assertEquals($user[User::COL_EMAIL], $userTest[User::COL_EMAIL]);
        Hash::check($motDePasse, $userTest[User::COL_HASH_PASSWORD]);
    }

}
