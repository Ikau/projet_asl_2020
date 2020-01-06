<?php

namespace Tests\Unit\Modeles;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

use App\Modeles\Soutenance;
use App\Modeles\Option;
use App\ModeleS\Departement;
use App\Utils\Constantes;

class SoutenanceTest extends TestCase
{
    /**
     * Test du constructeur du modele
     * 
     * @return void
     */
    public function testConstructeur()
    {
        $soutenance = new Soutenance();

        // Copier/Coller des attributs 'protected' du modele
        $attributesTests = [
            // Attributs propres au modele
            Soutenance::COL_ANNEE_ETUDIANT  => Constantes::INT_VIDE,
            Soutenance::COL_CAMPUS          => Constantes::STRING_VIDE,
            Soutenance::COL_COMMENTAIRE     => Constantes::STRING_VIDE,
            Soutenance::COL_CONFIDENTIELLE  => TRUE,
            Soutenance::COL_DATE            => Constantes::DATE_VIDE,
            Soutenance::COL_HEURE           => Constantes::HEURE_VIDE,
            Soutenance::COL_INVITES         => Constantes::STRING_VIDE,
            Soutenance::COL_NB_REPAS        => Constantes::INT_VIDE,
            Soutenance::COL_SALLE           => Constantes::STRING_VIDE,

            // Clefs etrangeres
            Soutenance::COL_CANDIDE_ID             => Constantes::ID_VIDE,
            //Soutenance::COL_CONTACT_ENTREPRISE_ID  => Constantes::ID_VIDE,
            Soutenance::COL_DEPARTEMENT_ID         => Constantes::ID_VIDE,
            Soutenance::COL_ETUDIANT_ID            => Constantes::ID_VIDE,
            Soutenance::COL_OPTION_ID              => Constantes::ID_VIDE,
            Soutenance::COL_REFERENT_ID            => Constantes::ID_VIDE,
        ];

        // Verification du constructeur
        $nbCompte = 1; // On suppose l'ID existant
        foreach($attributesTests as $attribut => $valeur)
        {
            $this->assertEquals($valeur, $soutenance[$attribut]);
            $nbCompte++;
        }

        // Verification du nombre d'attributs
        $nbAttributs = count(Schema::getColumnListing(Soutenance::NOM_TABLE));
        $this->assertEquals($nbAttributs, $nbCompte);
    }
}
