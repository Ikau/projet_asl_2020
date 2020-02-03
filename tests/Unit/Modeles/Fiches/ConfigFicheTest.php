<?php

namespace Tests\Unit\Modeles\Fiches;

use App\Modeles\Fiches\ConfigFiche;
use App\Utils\Constantes;
use Tests\TestCase;

class ConfigFicheTest extends TestCase
{
    public function testContructeurEloquent()
    {
        $configFiche = new ConfigFiche;

        $attributsTest = [
            ConfigFiche::COL_TYPE     => Constantes::STRING_VIDE,
            ConfigFiche::COL_VERSION  => Constantes::INT_VIDE,
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTest, $configFiche, ConfigFiche::NOM_TABLE, 0);

    }
}
