<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\UserType;

class CreerTableUsertypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(UserType::NOM_TABLE, function(Blueprint $table) {
            $table->bigIncrements('id');

            $table->string(UserType::COL_INTITULE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(UserType::NOM_TABLE);
    }
}
