<?php

namespace Tests\Unit\Modeles;

use App\Facade\UserFacade;
use App\Modeles\Contact;
use App\Modeles\Enseignant;
use App\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserFacadeTest extends TestCase
{
    /* ====================================================================
     *                       CONSTRUCTEURS STATIQUES
     * ====================================================================
     */

    public function testCreerDepuisContact()
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

    public function testCreerDepuisEnseignant()
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

    /**
     * @dataProvider echecCreerUserProvider
     */
    public function testEchecCreerUser($id, bool $idNull, string $motDePasse)
    {
        if($idNull)
        {
            $this->expectException('TypeError');
        }

        $user = UserFacade::creerDepuisContact($id, $motDePasse);
        $this->assertNull($user);

        $user = UserFacade::creerDepuisEnseignant($id, $motDePasse);
        $this->assertNull($user);
    }

    public function echecCreerUserProvider()
    {
        $faker = Faker::create();

        // [$id, bool $idNull, string $motDePasse]
        return [
            'Id null'     => [null, TRUE, $faker->word],
            'Id invalide' => [-1, FALSE, $faker->word]
        ];
    }
}
