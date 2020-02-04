<?php

namespace Tests\Unit\Modeles\Fiches;

use App\Modeles\Fiches\ModeleNotation;
use App\Utils\Constantes;
use Tests\TestCase;

class ModeleNotationTest extends TestCase
{
    public function testContructeurEloquent()
    {
        $configFiche = new ModeleNotation;

        $attributsTest = [
            ModeleNotation::COL_TYPE             => Constantes::STRING_VIDE,
            ModeleNotation::COL_VERSION          => Constantes::INT_VIDE,
            ModeleNotation::COL_POLY_MODELE_ID   => Constantes::ID_VIDE,
            ModeleNotation::COL_POLY_MODELE_TYPE => Constantes::STRING_VIDE,
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTest, $configFiche, ModeleNotation::NOM_TABLE);

    }
}
