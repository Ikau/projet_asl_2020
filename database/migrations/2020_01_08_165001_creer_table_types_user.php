<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\TypeUser;

class CreerTableTypesUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(TypeUser::NOM_TABLE, function(Blueprint $table) {
            $table->bigIncrements('id');

            $table->string(TypeUser::COL_INTITULE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(TypeUser::NOM_TABLE);
    }
}
