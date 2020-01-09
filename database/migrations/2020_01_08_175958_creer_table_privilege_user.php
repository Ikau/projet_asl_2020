<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\User;
use App\Modeles\Privilege;


class CreerTablePrivilegeUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Rappel : User::NOM_TABLE_PIVOT_PRIVILEGE_USER === Privilege::NOM_TABLE_PIVOT_PRIVILEGE_USER
        Schema::create(User::NOM_TABLE_PIVOT_PRIVILEGE_USER, function(Blueprint $table) {

            // Clefs etrangeres
            $table->unsignedBigInteger(User::COL_PIVOT_PRIVILEGE_USER);
            $table->unsignedBigInteger(Privilege::COL_PIVOT_PRIVILEGE_USER);

            $table->foreign(User::COL_PIVOT_PRIVILEGE_USER)->references('id')->on(User::NOM_TABLE);
            $table->foreign(Privilege::COL_PIVOT_PRIVILEGE_USER)->references('id')->on(Privilege::NOM_TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}