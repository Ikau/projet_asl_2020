<?php

namespace Tests\Unit\Modeles\Fiches;

use App\Modeles\Fiches\ModeleFiche;
use App\Utils\Constantes;
use Tests\TestCase;

class ModeleFicheTest extends TestCase
{
    public function testContructeurEloquent()
    {
        $configFiche = new ModeleFiche;

        $attributsTest = [
            ModeleFiche::COL_TYPE             => Constantes::STRING_VIDE,
            ModeleFiche::COL_VERSION          => Constantes::INT_VIDE,
            ModeleFiche::COL_POLY_MODELE_ID   => Constantes::ID_VIDE,
            ModeleFiche::COL_POLY_MODELE_TYPE => Constantes::STRING_VIDE,
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTest, $configFiche, ModeleFiche::NOM_TABLE);

    }
}
