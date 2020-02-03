<?php

namespace Tests\Unit\Modeles;

use App\Modeles\Fiches\Critere;
use App\Utils\Constantes;
use Tests\TestCase;

class CritereTest extends TestCase
{
    public function testConstructeur()
    {
        $question = new Critere;

        $attributsTests = [
            Critere::COL_CHOIX      => Constantes::STRING_VIDE,
            Critere::COL_INTITULE   => Constantes::STRING_VIDE,
            Critere::COL_SECTION_ID => Constantes::ID_VIDE,
            Critere::COL_ORDRE      => Constantes::INT_VIDE
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTests, $question, Critere::NOM_TABLE);
    }
}
