<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\User;
use App\UserType;

class CreerTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(User::NOM_TABLE, function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string(User::COL_EMAIL)->unique();
            $table->timestamp(User::COL_EMAIL_VERIFIE_LE)->nullable();
            $table->string(User::COL_HASH_PASSWORD);
            $table->rememberToken();
            
            // Clefs etrangeres polymorphique
            $table->morphs(User::COL_POLY_MODELE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(User::NOM_TABLE);
    }
}
