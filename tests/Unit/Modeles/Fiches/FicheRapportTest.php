<?php

namespace Tests\Unit\Modeles\Fiches;

use App\Modeles\Fiches\FicheRapport;
use App\Utils\Constantes;
use Tests\TestCase;

class FicheRapportTest extends TestCase
{
    public function testConstructeurEloquent()
    {
        $ficheRapport = new FicheRapport;

        $attributsTests = [
            // Attributs propres au modele
            FicheRapport::COL_APPRECIATION => Constantes::STRING_VIDE,
            FicheRapport::COL_CONTENU      => Constantes::STRING_VIDE,

            // Clefs etrangeres_
            FicheRapport::COL_SYNTHESE_ID => Constantes::ID_VIDE,
            FicheRapport::COL_STAGE_ID    => Constantes::ID_VIDE,
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTests, $ficheRapport, FicheRapport::NOM_TABLE);
    }
}
