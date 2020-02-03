<?php

namespace Tests\Unit\Modeles;

use App\Modeles\Fiches\Section;
use App\Utils\Constantes;
use Tests\TestCase;

class SectionTest extends TestCase
{
    public function testConstructeur()
    {
        $section = new Section;

        $attributsTests = [
            Section::COL_INTITULE => Constantes::STRING_VIDE,
            Section::COL_POLY_MODELE_ID   => Constantes::ID_VIDE,
            Section::COL_POLY_MODELE_TYPE => Constantes::STRING_VIDE
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTests, $section, Section::NOM_TABLE);
    }
}
