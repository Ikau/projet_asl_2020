<?php

namespace Tests\Unit\Modeles;

use App\Modeles\Enseignant;
use App\Utils\Constantes;
use Tests\TestCase;

class EnseignantTest extends TestCase
{
    /**
     * Test du constructeur du modele
     *
     * @return void
     */
    public function testConstructeur()
    {
        $enseignant = new Enseignant();

        $attributsTests = [
            Enseignant::COL_NOM                        => Constantes::STRING_VIDE,
            Enseignant::COL_PRENOM                     => Constantes::STRING_VIDE,
            Enseignant::COL_EMAIL                      => Constantes::STRING_VIDE,

            Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID => Constantes::ID_VIDE,
            Enseignant::COL_RESPONSABLE_OPTION_ID      => Constantes::ID_VIDE
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTests, $enseignant, Enseignant::NOM_TABLE);
    }
}
