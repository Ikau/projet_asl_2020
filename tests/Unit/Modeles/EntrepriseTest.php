<?php

namespace Tests\Unit\Modeles;

use App\Modeles\Entreprise;
use App\Utils\Constantes;
use Tests\TestCase;

class EntrepriseTest extends TestCase
{
    /**
     * Test du constructeur du modele
     *
     * @return void
     */
    public function testConstructeur()
    {
        $entreprise = new Entreprise();

        // Copier/Coller des attributs 'protected' du modele
        $attributesTests = [
            // Attributs propres au modele
            Entreprise::COL_NOM      => Constantes::STRING_VIDE,
            Entreprise::COL_ADRESSE  => Constantes::STRING_VIDE,
            Entreprise::COL_ADRESSE2 => Constantes::STRING_VIDE,
            Entreprise::COL_CP       => Constantes::STRING_VIDE,
            Entreprise::COL_VILLE    => Constantes::STRING_VIDE,
            Entreprise::COL_REGION   => Constantes::STRING_VIDE,
            Entreprise::COL_PAYS     => Constantes::STRING_VIDE,

            // Clefs etrangeres
        ];

        $this->verifieIntegriteConstructeurEloquent($attributesTests, $entreprise, Entreprise::NOM_TABLE);
    }
}
