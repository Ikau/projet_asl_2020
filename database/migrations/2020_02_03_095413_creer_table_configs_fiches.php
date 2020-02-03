<?php

use App\Modeles\ConfigFiche;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreerTableConfigsFiches extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(ConfigFiche::NOM_TABLE, function(Blueprint $table) {
            // Definition du schema de la table
            $table->string(ConfigFiche::COL_TYPE);
            $table->unsignedInteger(ConfigFiche::COL_VERSION);

            // On indique que la combinaison est unique
            $table->unique([ConfigFiche::COL_VERSION, ConfigFiche::COL_TYPE]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(ConfigFiche::NOM_TABLE);
    }
}
