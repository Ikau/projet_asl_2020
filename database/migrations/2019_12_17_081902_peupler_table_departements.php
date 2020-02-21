<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Modeles\Departement;

class PeuplerTableDepartements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table(Departement::NOM_TABLE)->insert([
            [Departement::COL_INTITULE => 'MRI'],
            [Departement::COL_INTITULE => 'STI']
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Supression brutale
        DB::table(Departement::NOM_TABLE)->truncate();
    }
}
