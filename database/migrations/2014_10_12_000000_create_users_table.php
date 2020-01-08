<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\User;

class CreateUsersTable extends Migration
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
            $table->timestamps();
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
