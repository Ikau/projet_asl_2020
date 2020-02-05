<?php

use Faker\Factory as Faker;

use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Fiches\ModeleNotation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Etudiant;
use App\Modeles\Stage;

class PeuplerTableStages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Stages aleatoires
        $nbEtudiant = DB::table(Etudiant::NOM_TABLE)->count();
        for($i=0; $i<$nbEtudiant; $i++)
        {
            // Creation du stage
            $stage = factory(Stage::class)->create();

            // Creation des fiches associees
            factory(FicheRapport::class)->create([
                FicheRapport::COL_MODELE_ID => $this->getIdModeleNotationRecent(),
                FicheRapport::COL_STAGE_ID  => $stage->id,
                FicheRapport::COL_CONTENU   => $this->getContenuModeleRaport()
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table(FicheRapport::NOM_TABLE)->delete();
        DB::table(Stage::NOM_TABLE)->delete();
    }

    /* ====================================================================
     *                        FONCTION AUXILIAIRES
     * ====================================================================
     */
    /**
     * @return int Id du modele de notation de rapport le plus recent
     */
    private function getIdModeleNotationRecent()
    {
        $modele = ModeleNotation::where(ModeleNotation::COL_TYPE, '=', ModeleNotation::VAL_RAPPORT)
            ->orderBy(ModeleNotation::COL_VERSION, 'desc')
            ->first();

        return $modele->id;
    }

    /**
     * @return false|string JSON du contenu d'une fiche de notation de rapport
     */
    private function getContenuModeleRaport()
    {
        $faker   = Faker::create();
        $contenu = [
            0 => [$faker->randomElement([0, 1, 2, 3]),
                $faker->randomElement([0, 1, 2, 3]),
                $faker->randomElement([0, 1, 2, 3])
            ],
            1 => [$faker->randomElement([0, 1, 2, 3]),
                $faker->randomElement([0, 1, 2, 3]),
                $faker->randomElement([0, 1, 2, 3])
            ],
            2 => [$faker->randomElement([0, 1, 2, 3]),
                $faker->randomElement([0, 1, 2, 3])
            ],
        ];

        return json_encode($contenu);
    }

}
