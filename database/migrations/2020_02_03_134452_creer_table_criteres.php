<?php

use App\Modeles\Fiches\Critere;
use App\Modeles\Fiches\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreerTableCriteres extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Critere::NOM_TABLE, function(Blueprint $table) {
            $table ->bigIncrements('id');

            // Colonnes de la table
            $table->text(Critere::COL_INTITULE);
            $table->text(Critere::COL_CHOIX);

            // Clefs etrangeres
            $table->unsignedBigInteger(Critere::COL_SECTION_ID);
            $table->foreign(Critere::COL_SECTION_ID)->references('id')->on(Section::NOM_TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Critere::NOM_TABLE);
    }
}
