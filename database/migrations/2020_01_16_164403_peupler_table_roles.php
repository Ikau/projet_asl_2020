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
        $roles = [
            Role::VAL_ADMIN,
            Role::VAL_REFERENT,
            Role::VAL_SCOLARITE,
        ];

        foreach($roles as $role)
        {
            $nouveauRole = new Role;
            $nouveauRole[Role::COL_INTITULE] = $role;
            $nouveauRole->save();
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
