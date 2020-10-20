<?php

namespace Tests\Unit\Modeles;

use App\Modeles\Privilege;
use App\Utils\Constantes;
use Tests\TestCase;

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
