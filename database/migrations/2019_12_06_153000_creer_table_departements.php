<?php

use App\Modeles\Enseignant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Departement;

class CreerTableDepartements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Departement::NOM_TABLE, function(Blueprint $table) {
            $table->bigIncrements('id');

            // Colonnes
            $table->string(Departement::COL_INTITULE);

            // Clefs etrangeres
            $table->unsignedBigInteger(Departement::COL_RESPONSABLE_ID)->nullable(); // Si aucun responsable n'est determine

            $table->foreign(Departement::COL_RESPONSABLE_ID)->references('id')->on(Enseignant::NOM_TABLE)->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Departement::NOM_TABLE);
    }
}
