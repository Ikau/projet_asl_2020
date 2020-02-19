<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Modeles\Role;

class PeuplerTableRoles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Insertions de quelques roles standards
        foreach(Role::getValeurs() as $intitules)
        {
            $role = new Role;
            $role[Role::COL_INTITULE] = $intitules;
            $role->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table(Role::NOM_TABLE)->delete();
    }
}
