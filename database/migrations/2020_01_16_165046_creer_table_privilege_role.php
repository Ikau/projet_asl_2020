<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Modeles\Privilege;
use App\Modeles\Role;

class CreerTablePrivilegeRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Rappel : Privilege::NOM_TABLE_PIVOT_PRIVILEGE_ROLE === Role::NOM_TABLE_PIVOT_PRIVILEGE_ROLE
        Schema::create(Privilege::NOM_TABLE_PIVOT_PRIVILEGE_ROLE, function(Blueprint $table) {

            // Clefs etrangeres
            $table->unsignedBigInteger(Privilege::COL_PIVOT);
            $table->unsignedBigInteger(Role::COL_PIVOT);

            $table->foreign(Privilege::COL_PIVOT)->references('id')->on(Privilege::NOM_TABLE);
            $table->foreign(Role::COL_PIVOT)->references('id')->on(Role::NOM_TABLE);

            // On indique que la combinaison est unique
            $table->unique([Privilege::COL_PIVOT, Role::COL_PIVOT]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::dropIfExists(Privilege::NOM_TABLE_PIVOT_PRIVILEGE_ROLE);
    }
}
