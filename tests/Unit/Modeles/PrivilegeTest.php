<?php

namespace Tests\Unit\Modeles;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Modeles\Privilege;
use App\Utils\Constantes;

class PrivilegeTest extends TestCase
{
    /**
     * Test du constructeur du modele
     */
    public function testConstructeur()
    {
        $privilege = new Privilege;

        $attributs = [
            Privilege::COL_INTITULE => Constantes::STRING_VIDE
        ];

        $this->verifieIntegriteConstructeurEloquent($attributs, $privilege, Privilege::NOM_TABLE);
    }
}
