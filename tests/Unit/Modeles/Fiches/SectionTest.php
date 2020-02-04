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
            Section::COL_CHOIX     => Constantes::STRING_VIDE,
            Section::COL_CRITERES  => Constantes::STRING_VIDE,
            Section::COL_INTITULE  => Constantes::STRING_VIDE,
            Section::COL_MODELE_ID => Constantes::ID_VIDE,
            Section::COL_ORDRE     => Constantes::INT_VIDE,
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTests, $section, Section::NOM_TABLE);
    }
}
