<?php

use App\Modeles\Fiches\ModeleNotation;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreerTableModelesNotation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ModeleNotation::NOM_TABLE, function(Blueprint $table) {
            $table->bigIncrements('id');

            // Definition du schema de la table
            $table->string(ModeleNotation::COL_TYPE);
            $table->unsignedInteger(ModeleNotation::COL_VERSION);

            // On indique que la combinaison est unique
            $table->unique([ModeleNotation::COL_VERSION, ModeleNotation::COL_TYPE]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(ModeleNotation::NOM_TABLE);
    }
}
