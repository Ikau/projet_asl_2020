<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Privilege;

class CreerTablePrivileges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Privilege::NOM_TABLE, function(Blueprint $table) {
            $table->bigIncrements('id');

            $table->string(Privilege::COL_INTITULE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Privilege::NOM_TABLE);
    }
}
