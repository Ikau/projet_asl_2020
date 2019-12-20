<?php

namespace Tests\Unit\Modeles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Modeles\Entreprise;
use App\Utils\Constantes;

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

        // Verification du constructeur
        $nbCompte = 1; // On suppose l'ID existant
        foreach($attributesTests as $attribut => $valeur)
        {
            $this->assertEquals($valeur, $entreprise[$attribut]);
            $nbCompte++;
        }

        // Verification du nombre d'attributs
        $nbAttributs = count(Schema::getColumnListing(Entreprise::NOM_TABLE));
        $this->assertEquals($nbAttributs, $nbCompte);
    }
}
