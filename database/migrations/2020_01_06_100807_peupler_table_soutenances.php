<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Soutenance;

class PeuplerTableSoutenances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $nbSoutenance = 20;
        for($i=0; $i<$nbSoutenance; $i++)
        {
            factory(Soutenance::class)->create();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table(Soutenance::class)->delete();
    }
}
