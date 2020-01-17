<?php 

namespace Tests\Unit\Modeles;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Modeles\Privilege;
use App\Utils\Constantes;

class PrivilegeTest extends TestCase
{
    /**
     * Test du constructeur du modele
     */
    public function testConstructeur()
    {
        $privilege        = new Privilege;
        $compteurAttribut = 1; // On suppose l'ID existant
        $attributs = [
            Privilege::COL_INTITULE => Constantes::STRING_VIDE
        ];

        // Integrite du constructeur
        foreach($attributs as $clef => $valeur)
        {
            $this->assertEquals($valeur, $privilege[$clef]);
            $compteurAttribut++;
        }

        // Integrite des attributs
        $nbAttributs = count(Schema::getColumnListing(Privilege::NOM_TABLE));
        $this->assertEquals($nbAttributs, $compteurAttribut);
    }
}