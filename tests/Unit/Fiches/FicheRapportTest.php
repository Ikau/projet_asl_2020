<?php

namespace Tests\Unit\Modeles\Fiches;


use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Stage;
use App\Traits\TestFiches;
use App\Utils\Constantes;
use Tests\TestCase;

class FicheRapportTest extends TestCase
{
    use TestFiches;

    public function testConstructeurEloquent()
    {
        $ficheRapport = new FicheRapport();

        $attributsTests = [
            // Attributs propres au modele
            FicheRapport::COL_APPRECIATION => Constantes::STRING_VIDE,
            FicheRapport::COL_CONTENU      => Constantes::STRING_VIDE,
            FicheRapport::COL_STATUT       => FicheRapport::VAL_STATUT_NOUVELLE,

            // Clefs etrangeres_
            FicheRapport::COL_MODELE_ID   => Constantes::ID_VIDE,
            FicheRapport::COL_STAGE_ID    => Constantes::ID_VIDE,
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTests, $ficheRapport, FicheRapport::NOM_TABLE);
    }

    public function testGetNote()
    {
        // Recuperation d'un modele de notation
        $modele = $this->getPlusRecentModeleRapport();

        // Test d'un contenu 20 / 20 selon le modele
        $contenuModel = [
            0 => [0, 0, 0],
            1 => [0, 0, 0, 0],
            2 => [0, 0]
        ];

        $stage         = factory(Stage::class)->create();
        $ficheRapport  = factory(FicheRapport::class)->create([
            FicheRapport::COL_STAGE_ID  => $stage->id,
            FicheRapport::COL_CONTENU   => $contenuModel,
            FicheRapport::COL_MODELE_ID => $modele->id,
            FicheRapport::COL_STATUT    => FicheRapport::VAL_STATUT_COMPLETE
        ]);

        $this->assertEquals(20.0, $ficheRapport->getNote());
    }

    /**
     * @dataProvider getStatutProvider
     * @param int $statutAttendu
     * @param array $contenu
     */
    public function testGetStatut(int $statutAttendu, array $contenu)
    {
        // Recuperation d'un modele de notation
        $modele = $this->getPlusRecentModeleRapport();

        $stage         = factory(Stage::class)->create();
        $ficheRapport  = factory(FicheRapport::class)->create([
            FicheRapport::COL_STAGE_ID  => $stage->id,
            FicheRapport::COL_CONTENU   => $contenu,
            FicheRapport::COL_MODELE_ID => $modele->id,
            FicheRapport::COL_STATUT    => FicheRapport::VAL_STATUT_COMPLETE
        ]);

        $this->assertEquals($statutAttendu, $ficheRapport->getStatut());
    }

    public function getStatutProvider()
    {
        // int $statutAttendu, array $contenu
        return [
            'Fiche complete'        => [
                FicheRapport::VAL_STATUT_COMPLETE,
                [
                    [0, 1, 2],
                    [0, 1, 2, 3],
                    [0, 1]
                ]
            ],
            'Fiche en cours'        => [
                FicheRapport::VAL_STATUT_EN_COURS,
                [
                    [0, 1, 2],
                    [0, -1, 2, 3],
                    [0, 1]
                ]
            ],
            'Fiche vierge vide'     => [
                FicheRapport::VAL_STATUT_NOUVELLE,
                []
            ],
            'Fiche vierge nouvelle' => [
                FicheRapport::VAL_STATUT_NOUVELLE,
                [
                    [-1, -1, -1],
                    [-1, -1, -1, -1],
                    [-1, -1]
                ]
            ]
        ];
    }
}
