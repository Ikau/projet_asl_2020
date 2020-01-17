<?php 

namespace Tests\Unit\Modeles;

use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Modeles\Role;
use App\Utils\Constantes;

class RoleTest extends TestCase
{
    /**
     * Test du constructeur du modele
     */
    public function testConstructeur()
    {
        $role              = new Role;
        $compteurAttributs = 1; // On suppose l'ID existant
        $attributs         = [
            Role::COL_INTITULE => Constantes::STRING_VIDE
        ];

        // Integrite du constructeur
        foreach($attributs as $clef => $valeur)
        {
            $this->assertEquals($valeur, $role[$clef]);
            $compteurAttributs++;
        }

        // Integrite des attributs
        $nbAttributs = count(Schema::getColumnListing(Role::NOM_TABLE));
        $this->assertEquals($nbAttributs, $compteurAttributs);
    }
}