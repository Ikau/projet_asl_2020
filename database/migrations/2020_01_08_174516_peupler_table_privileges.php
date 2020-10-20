<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Modeles\Privilege;

class PeuplerTablePrivileges extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach(Privilege::getValeurs() as $intitule)
        {
            $privilege = new Privilege;
            $privilege[Privilege::COL_INTITULE] = $intitule;
            $privilege->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table(Privilege::NOM_TABLE)->delete();
    }
}
