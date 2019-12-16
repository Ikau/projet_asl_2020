<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Enseignant;
use App\Modeles\Departement;
use App\Modeles\Option;


class CreerTableEnseignants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Enseignant::NOM_TABLE, function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom');
            $table->string('prenom');
            $table->string('email');

            $table->unsignedBigInteger(Enseignant::COL_RESPONSABLE_OPTION_ID);
            $table->unsignedBigInteger(Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID);

            $table->foreign(Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID)->references('id')->on(Departement::NOM_TABLE);
            $table->foreign(Enseignant::COL_RESPONSABLE_OPTION_ID)->references('id')->on(Option::NOM_TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Enseignant::NOM_TABLE);
    }
}
