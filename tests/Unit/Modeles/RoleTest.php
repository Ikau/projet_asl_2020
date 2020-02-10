<?php

namespace Tests\Unit\Modeles;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Modeles\Role;
use App\Utils\Constantes;

class RoleTest extends TestCase
{
    /**
     * Test du constructeur du modele
     */
    public function testConstructeur()
    {
        $role = new Role;

        $attributs = [
            Role::COL_INTITULE => Constantes::STRING_VIDE
        ];

        $this->verifieIntegriteConstructeurEloquent($attributs, $role, Role::NOM_TABLE);
    }
}
