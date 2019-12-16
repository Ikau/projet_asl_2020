<?php

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

            $table->string('intitule');
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
