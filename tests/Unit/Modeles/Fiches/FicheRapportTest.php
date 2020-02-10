<?php

namespace Tests\Unit\Modeles\Fiches;


use Faker\Generator as Faker;

use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Fiches\FicheSynthese;
use App\Modeles\Fiches\ModeleNotation;
use App\Modeles\Stage;
use App\Utils\Constantes;
use Tests\TestCase;

class FicheRapportTest extends TestCase
{
    public function testConstructeurEloquent()
    {
        $ficheRapport = new FicheRapport();

        $attributsTests = [
            // Attributs propres au modele
            FicheRapport::COL_APPRECIATION => Constantes::STRING_VIDE,
            FicheRapport::COL_CONTENU      => Constantes::STRING_VIDE,

            // Clefs etrangeres_
            FicheRapport::COL_MODELE_ID   => Constantes::ID_VIDE,
            FicheRapport::COL_STAGE_ID    => Constantes::ID_VIDE,
        ];

        $this->verifieIntegriteConstructeurEloquent($attributsTests, $ficheRapport, FicheRapport::NOM_TABLE);
    }

    public function testGetNote()
    {
        // Recuperation d'un modele de notation
        $modele = ModeleNotation::where(ModeleNotation::COL_TYPE, '=', ModeleNotation::VAL_RAPPORT)
            ->orderBy(ModeleNotation::COL_VERSION, 'desc')
            ->limit(1)
            ->first();

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
            FicheRapport::COL_MODELE_ID => $modele->id
        ]);

        $this->assertEquals(20.0, $ficheRapport->getNote());
    }
}
