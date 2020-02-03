<?php

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

            // Clef etrangeres polymorphiques
            $table->morphs(Section::COL_POLY_MODELE);
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
