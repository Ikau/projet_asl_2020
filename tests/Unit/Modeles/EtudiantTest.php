<?php

namespace Tests\Unit\Modeles;

use App\Modeles\Etudiant;
use App\Utils\Constantes;
use Tests\TestCase;

class EtudiantTest extends TestCase
{
    /**
     * Test du constructeur du modele
     *
     * @return void
     */
    public function testConstructeur()
    {
        $etudiant = new Etudiant();

        $attributsTests = [
            //Etudiant::COL_MATRICULE     => Constantes::STRING_VIDE,
            Etudiant::COL_NOM           => Constantes::STRING_VIDE,
            Etudiant::COL_PRENOM        => Constantes::STRING_VIDE,
            Etudiant::COL_EMAIL         => Constantes::STRING_VIDE,
            //Etudiant::COL_CIVILITE      => Contact::VAL_CIVILITE_VIDE,
            //Etudiant::COL_INSCRIPTION   => Constantes::DATE_VIDE,
            //Etudiant::COL_NATIONALITE   => Constantes::NATIONALITE['vide'],
            //Etudiant::COL_FORMATION     => Constantes::FORMATION['vide'],
            //Etudiant::COL_MASTER        => Constantes::MASTER['vide'],
            //Etudiant::COL_DIPLOME       => Constantes::DIPLOME['vide'],
            Etudiant::COL_ANNEE         => Constantes::INT_VIDE,
            Etudiant::COL_MOBILITE      => FALSE,
            Etudiant::COL_PROMOTION     => Constantes::STRING_VIDE,

            Etudiant::COL_DEPARTEMENT_ID => Constantes::ID_VIDE,
            Etudiant::COL_OPTION_ID      => Constantes::ID_VIDE
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTests, $etudiant, Etudiant::NOM_TABLE);

    }
}
