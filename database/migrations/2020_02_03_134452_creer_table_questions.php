<?php

use App\Modeles\Fiches\Question;
use App\Modeles\Fiches\Section;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreerTableQuestions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Question::NOM_TABLE, function(Blueprint $table) {
            $table ->bigIncrements('id');

            // Colonnes de la table
            $table->text(Question::COL_INTITULE);
            $table->text(Question::COL_CHOIX);

            // Clefs etrangeres
            $table->unsignedBigInteger(Question::COL_SECTION_ID);
            $table->foreign(Question::COL_SECTION_ID)->references('id')->on(Section::NOM_TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Question::NOM_TABLE);
    }
}
