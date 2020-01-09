<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\User;
use App\Modeles\Privilege;

class PeuplerTablePrivilegeUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         *  Insertion admin 
         */
        // Recuperation des modeles
        $userAdmin = User::where(User::COL_EMAIL, '=', 'admin@insa-cvl.fr')->first();
        $privilegeAdmin = Privilege::where(Privilege::COL_INTITULE, '=', 'Admin')->first();

        // Insertions
        $userAdmin->privileges()->attach($privilegeAdmin->id);
        $userAdmin->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table(User::NOM_TABLE_PIVOT_PRIVILEGE_USER)->delete();
    }
}
