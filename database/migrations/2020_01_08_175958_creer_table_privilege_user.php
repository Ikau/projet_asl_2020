<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
        Schema::create(Privilege::NOM_TABLE_PIVOT_PRIVILEGE_USER, function(Blueprint $table) {

            // Clefs etrangeres
            $table->unsignedBigInteger(User::COL_PIVOT);
            $table->unsignedBigInteger(Privilege::COL_PIVOT);

            $table->foreign(User::COL_PIVOT)->references('id')->on(User::NOM_TABLE);
            $table->foreign(Privilege::COL_PIVOT)->references('id')->on(Privilege::NOM_TABLE);

            // On indique que la combinaison est unique
            $table->unique([User::COL_PIVOT, Privilege::COL_PIVOT]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Privilege::NOM_TABLE_PIVOT_PRIVILEGE_USER);
    }
}
