<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Fiches\FicheSoutenance;
use App\Modeles\Fiches\FicheSynthese;
use App\Modeles\Soutenance;
use App\Modeles\Stage;

class CreerTableFichesSoutenance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(FicheSoutenance::NOM_TABLE, function(Blueprint $table) {
            $table->bigIncrements('id');

            $table->float('malus');
            $table->unsignedDecimal('note');
            $table->text('appreciation');
            $table->unsignedBigInteger(FicheSoutenance::COL_SOUTENANCE_ID);
            $table->unsignedBigInteger(FicheSoutenance::COL_STAGE_ID);
            $table->unsignedBigInteger(FicheSoutenance::COL_SYNTHESE_ID);

            $table->foreign(FicheSoutenance::COL_SOUTENANCE_ID)->references('id')->on(Soutenance::NOM_TABLE);
            $table->foreign(FicheSoutenance::COL_STAGE_ID)->references('id')->on(Stage::NOM_TABLE);
            $table->foreign(FicheSoutenance::COL_SYNTHESE_ID)->references('id')->on(FicheSynthese::NOM_TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(FicheSoutenance::NOM_TABLE);
    }
}
