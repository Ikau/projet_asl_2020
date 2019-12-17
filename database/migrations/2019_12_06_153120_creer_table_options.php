<?php

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

            $table->string('intitule');
            $table->unsignedBigInteger(Option::COL_DEPARTEMENT_ID);

            $table->foreign(Option::COL_DEPARTEMENT_ID)->references('id')->on(Departement::NOM_TABLE);
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
