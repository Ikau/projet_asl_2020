<?php

namespace Tests\Unit\Modeles\Fiches;

use App\Modeles\Fiches\FicheSynthese;
use App\Utils\Constantes;
use Tests\TestCase;

class FicheSyntheseTest extends TestCase
{
    public function testConstructeurEloquent()
    {
        $ficheSynthese = new FicheSynthese();

        $attributsTests = [
            // Attributs propres au modele
            FicheSynthese::COL_COEFFICIENTS => Constantes::STRING_VIDE,
            FicheSynthese::COL_MODIFIEUR    => Constantes::FLOAT_VIDE,

            // Clefs etrangeres
            FicheSynthese::COL_STAGE_ID => Constantes::ID_VIDE
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTests, $ficheSynthese, FicheSynthese::NOM_TABLE);
    }
}
