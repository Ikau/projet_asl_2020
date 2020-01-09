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
        $privileges = [
            'Referent',
            'Responsable_option',
            'Scolarite',
            'Admin',
        ];

        foreach($privileges as $privilege)
        {
            $nouveauPrivilege = new Privilege;
            $nouveauPrivilege[Privilege::COL_INTITULE] = $privilege;
            $nouveauPrivilege->save();
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
