<?php

namespace Tests\Unit\Modeles;

use App\Modeles\Soutenance;
use App\Utils\Constantes;
use Tests\TestCase;

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
        $attributsTests = [
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

        $this->verifieIntegriteConstructeurEloquent($attributsTests, $soutenance, Soutenance::NOM_TABLE);
    }
}
