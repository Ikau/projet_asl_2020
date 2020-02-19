<?php

namespace Tests\Unit\Modeles;

use App\Modeles\Role;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
    public function testConstructeur()
    {
        $user = new User();

        $attributsTest = [
            User::COL_EMAIL               => null,
            User::COL_EMAIL_VERIFIE_LE    => null,
            User::COL_HASH_PASSWORD       => null,
            User::COL_REMEMBER_TOKEN      => null,
            User::COL_POLY_MODELE_ID      => null,
            User::COL_POLY_MODELE_TYPE    => null,
        ];

        // Verification du modele
        $this->verifieIntegriteConstructeurEloquent($attributsTest, $user, User::NOM_TABLE);
    }

    /**
     * Test des fonctions d'authentification dans un cas de reussite
     *
     * @dataProvider estProvider
     */
    public function testEst(string $intituleRole)
    {
        // Creation d'un utilisateur aleatoire
        $user = factory(User::class)->create();

        // Ajout de tous les roles sauf celui que l'on veut
        $role = Role::where(Role::COL_INTITULE, '=', $intituleRole)->first();
        $user->roles()->attach($role);
        $user->save();

        // Verification
        switch ($intituleRole)
        {
            case Role::VAL_ADMIN:
                $this->assertTrue($user->estAdministrateur());
                break;

            case Role::VAL_ENSEIGNANT:
                $this->assertTrue($user->estEnseignant());
                break;

            case Role::VAL_RESP_OPTION:
                $this->assertTrue($user->estResponsableOption());
                break;

            case Role::VAL_RESP_DEPARTEMENT:
                $this->assertTrue($user->estResponsableDepartement());
                break;

            case Role::VAL_SCOLARITE:
                $this->assertTrue($user->estScolariteINSA());
                break;
        }
    }

    /**
     * Test des fonctions d'authentification dans un cas d'echec
     *
     * @dataProvider estProvider
     */
    public function testEchecEst(string $intituleRole)
    {
        // Creation d'un utilisateur aleatoire
        $user = factory(User::class)->create();

        // Ajout de tous les roles sauf celui que l'on veut
        $roles = Role::all();
        foreach($roles as $role)
        {
            if($intituleRole !== $role[Role::COL_INTITULE])
            {
                $user->roles()->attach($role);
            }
        }
        $user->save();

        // Verification
        switch ($intituleRole)
        {
            case Role::VAL_ADMIN:
                $this->assertFalse($user->estAdministrateur());
                break;

            case Role::VAL_ENSEIGNANT:
                $this->assertFalse($user->estEnseignant());
                break;

            case Role::VAL_RESP_OPTION:
                $this->assertFalse($user->estResponsableOption());
                break;

            case Role::VAL_RESP_DEPARTEMENT:
                $this->assertFalse($user->estResponsableDepartement());
                break;

            case Role::VAL_SCOLARITE:
                $this->assertFalse($user->estScolariteINSA());
                break;
        }
    }

    public function estProvider()
    {
        // [string $intitule]
        return [
            Role::VAL_ADMIN            => [Role::VAL_ADMIN],
            Role::VAL_ENSEIGNANT       => [Role::VAL_ENSEIGNANT],
            Role::VAL_RESP_DEPARTEMENT => [Role::VAL_RESP_DEPARTEMENT],
            Role::VAL_RESP_OPTION      => [Role::VAL_RESP_OPTION],
            Role::VAL_SCOLARITE        => [Role::VAL_SCOLARITE]
        ];
    }
}
