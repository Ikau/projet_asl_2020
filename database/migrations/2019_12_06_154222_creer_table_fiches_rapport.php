<?php

use App\Modeles\Fiches\ModeleNotation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Fiches\FicheSynthese;
use App\Modeles\Stage;

class CreerTableFichesRapport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(FicheRapport::NOM_TABLE, function(Blueprint $table) {
            $table->bigIncrements('id');

            // Definition du schema de la table
            $table->text(FicheRapport::COL_APPRECIATION);
            $table->text(FicheRapport::COL_CONTENU);
            $table->unsignedSmallInteger(FicheRapport::COL_STATUT);

            // Clefs etrangeres
            $table->unsignedBigInteger(FicheRapport::COL_MODELE_ID);
            $table->unsignedBigInteger(FicheRapport::COL_STAGE_ID);

            $table->foreign(FicheRapport::COL_MODELE_ID)->references('id')->on(ModeleNotation::NOM_TABLE);
            $table->foreign(FicheRapport::COL_STAGE_ID)->references('id')->on(Stage::NOM_TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(FicheRapport::NOM_TABLE);
    }
}
