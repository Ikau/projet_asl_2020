<?php

use App\Facade\FicheFacade;
use App\Modeles\Fiches\FicheRapport;
use Illuminate\Database\Migrations\Migration;
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
            FicheFacade::creerFiches($stage->id);
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

}
