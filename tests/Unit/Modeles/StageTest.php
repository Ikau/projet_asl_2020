<?php

namespace Tests\Unit\Modeles;

use App\Modeles\Stage;
use App\Utils\Constantes;
use Tests\TestCase;

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
        $attributsTests = [
            // Attributs propres au modele
            Stage::COL_AFFECTATION_VALIDEE => FALSE,
            Stage::COL_ANNEE               => Constantes::INT_VIDE,
            Stage::COL_CONVENTION_ENVOYEE  => FALSE,
            Stage::COL_CONVENTION_SIGNEE   => FALSE,
            Stage::COL_DATE_DEBUT          => Constantes::DATE_VIDE,
            Stage::COL_DATE_FIN            => Constantes::DATE_VIDE,
            Stage::COL_DUREE_SEMAINES      => Constantes::INT_VIDE,
            Stage::COL_GRATIFICATION       => Constantes::FLOAT_VIDE,
            Stage::COL_INTITULE            => Constantes::STRING_VIDE,
            Stage::COL_LIEU                => Constantes::STRING_VIDE,
            Stage::COL_MOYEN_RECHERCHE     => Constantes::STRING_VIDE,
            Stage::COL_RESUME              => Constantes::STRING_VIDE,

            // Clefs etrangeres
            Stage::COL_REFERENT_ID   => Constantes::ID_VIDE,
            Stage::COL_ETUDIANT_ID   => Constantes::ID_VIDE,
            //Stage::COL_ENTREPRISE_ID => Constantes::ID_VIDE,
            //Stage::COL_MDS_ID        => Constantes::ID_VIDE,
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTests, $stage, Stage::NOM_TABLE);
    }
}
