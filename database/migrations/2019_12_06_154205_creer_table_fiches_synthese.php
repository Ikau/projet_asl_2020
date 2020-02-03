<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Fiches\FicheSynthese;
use App\Modeles\Stage;

class CreerTableFichesSynthese extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(FicheSynthese::NOM_TABLE, function(Blueprint $table) {
            $table->bigIncrements('id');

            $table->float('total_points');
            $table->float('modifieur');
            $table->unsignedDecimal('note_brute');
            $table->unsignedDecimal('note_finale');
            $table->unsignedBigInteger(FicheSynthese::COL_STAGE_ID);

            $table->foreign(FicheSynthese::COL_STAGE_ID)->references('id')->on(Stage::NOM_TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(FicheSynthese::NOM_TABLE);
    }
}
