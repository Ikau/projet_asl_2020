<?php

use App\Modeles\Fiches\ModeleFiche;
use App\Modeles\Fiches\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreerTableSections extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Section::NOM_TABLE, function(Blueprint $table) {
            $table->bigIncrements('id');

            // Colonnes de la table
            $table->string(Section::COL_INTITULE);

            // Clefs etrangeres
            $table->unsignedBigInteger(Section::COL_MODELE_ID);
            $table->foreign(Section::COL_MODELE_ID)->references('id')->on(ModeleFiche::NOM_TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Section::NOM_TABLE);
    }
}
