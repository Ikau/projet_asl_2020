<?php

namespace Tests\Unit\Modeles\Fiches;

use App\Modeles\Fiches\ModeleFiche;
use App\Utils\Constantes;
use Tests\TestCase;

class ConfigFicheTest extends TestCase
{
    public function testContructeurEloquent()
    {
        $configFiche = new ModeleFiche;

        $attributsTest = [
            ModeleFiche::COL_TYPE     => Constantes::STRING_VIDE,
            ModeleFiche::COL_VERSION  => Constantes::INT_VIDE,
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTest, $configFiche, ModeleFiche::NOM_TABLE, 0);

    }
}
