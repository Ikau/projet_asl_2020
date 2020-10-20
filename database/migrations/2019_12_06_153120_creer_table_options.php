<?php

use App\Modeles\Enseignant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Option;
use App\Modeles\Departement;

class CreerTableOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Option::NOM_TABLE, function(Blueprint $table){
            $table->bigIncrements('id');

            // Colonnes
            $table->string(Option::COL_INTITULE);

            // Clefs etrangeres
            $table->unsignedBigInteger(Option::COL_DEPARTEMENT_ID);
            $table->unsignedBigInteger(Option::COL_RESPONSABLE_ID)->nullable(); // Si un responsable n'est pas encore determine

            $table->foreign(Option::COL_DEPARTEMENT_ID)->references('id')->on(Departement::NOM_TABLE);
            $table->foreign(Option::COL_RESPONSABLE_ID)->references('id')->on(Enseignant::NOM_TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Option::NOM_TABLE);
    }
}
