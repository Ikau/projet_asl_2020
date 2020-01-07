<?php

namespace Tests\Unit\Modeles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

use App\Modeles\Enseignant;
use App\Modeles\Option;
use App\ModeleS\Departement;
use App\Utils\Constantes;

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

        // Verification du constructeur
        $nbCompte = 1; // On suppose l'ID existant
        foreach($attributsTests as $attribut => $valeur)
        {
            $this->assertEquals($valeur, $enseignant[$attribut]);
            $nbCompte++;
        }

        // Verification du nombre d'attributs
        $nbAttributs = count(Schema::getColumnListing(Enseignant::NOM_TABLE));
        $this->assertEquals($nbAttributs, $nbCompte);
    }
}
