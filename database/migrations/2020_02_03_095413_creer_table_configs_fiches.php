<?php

use App\Modeles\Fiches\ModeleFiche;
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
        Schema::create(ModeleFiche::NOM_TABLE, function(Blueprint $table) {
            // Definition du schema de la table
            $table->string(ModeleFiche::COL_TYPE);
            $table->unsignedInteger(ModeleFiche::COL_VERSION);

            // On indique que la combinaison est unique
            $table->unique([ModeleFiche::COL_VERSION, ModeleFiche::COL_TYPE]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(ModeleFiche::NOM_TABLE);
    }
}
