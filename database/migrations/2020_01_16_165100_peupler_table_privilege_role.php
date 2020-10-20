<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Modeles\Privilege;
use App\Modeles\Role;

class PeuplerTablePrivilegeRole extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*
         * Pour l'instant, la liste des privileges et des roles n'est pas determinee
         * 
         * On ajoutera la creation et l'affinage des roles au fur et a mesure du developpement 
         */
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Privilege::NOM_TABLE_PIVOT_PRIVILEGE_ROLE);
    }
}
