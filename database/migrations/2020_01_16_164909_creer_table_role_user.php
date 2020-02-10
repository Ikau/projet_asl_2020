<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Modeles\Role;

class CreerTableRoleUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Rappel : User::NOM_TABLE_PIVOT_ROLE_USER === Role::NOM_TABLE_PIVOT_ROLE_USER
        Schema::create(Role::NOM_TABLE_PIVOT_ROLE_USER, function(Blueprint $table) {
            
            // Clefs etrangeres
            $table->unsignedBigInteger(User::COL_PIVOT);
            $table->unsignedBigInteger(Role::COL_PIVOT);

            $table->foreign(User::COL_PIVOT)->references('id')->on(User::NOM_TABLE);
            $table->foreign(Role::COL_PIVOT)->references('id')->on(Role::NOM_TABLE);

            // On indique que la combinaison est unique
            $table->unique([User::COL_PIVOT, Role::COL_PIVOT]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::dropIfExists(Role::NOM_TABLE_PIVOT_ROLE_USER);
    }
}
