<?php

namespace Tests\Unit\Modeles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Modeles\Stage;
use App\Utils\Constantes;

class StageTest extends TestCase
{
    /**
     * Test du constructeur du modele
     * 
     * @return void
     */
    public function testConstructeur()
    {
        $stage = new Stage();

        // Copier/Coller des attributs 'protected' du modele
        $attributesTests = [
            // Attributs propres au modele
            Stage::COL_ANNEE              => Constantes::INT_VIDE,
            Stage::COL_CONVENTION_ENVOYEE => FALSE,
            Stage::COL_CONVENTION_SIGNEE  => FALSE,
            Stage::COL_DATE_DEBUT         => Constantes::DATE_VIDE,
            Stage::COL_DATE_FIN           => Constantes::DATE_VIDE,
            Stage::COL_DUREE_SEMAINES     => Constantes::INT_VIDE,
            Stage::COL_GRATIFICATION      => Constantes::FLOAT_VIDE,
            Stage::COL_INTITULE           => Constantes::STRING_VIDE,
            Stage::COL_LIEU               => Constantes::STRING_VIDE,
            Stage::COL_MOYEN_RECHERCHE    => Constantes::STRING_VIDE,
            Stage::COL_RESUME             => Constantes::STRING_VIDE,
            
            // Clefs etrangeres
            Stage::COL_REFERENT_ID   => Constantes::ID_VIDE,
            Stage::COL_ETUDIANT_ID   => Constantes::ID_VIDE,
            //Stage::COL_ENTREPRISE_ID => Constantes::ID_VIDE,
            //Stage::COL_MDS_ID        => Constantes::ID_VIDE,
        ];

        // Verification du constructeur
        $nbCompte = 1;
        foreach($attributesTests as $attribut => $valeur)
        {
            $this->assertEquals($valeur, $stage[$attribut]);
            $nbCompte++;
        }

        // Verification du nombre d'attributs
        $nbAttributs = count(Schema::getColumnListing(Stage::NOM_TABLE));
        $this->assertEquals($nbAttributs, $nbCompte);
    }
}
