<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Modeles\Enseignant;

class PeuplerTableEnseignants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $nbEnseignant = 10;
        for($i=0; $i<$nbEnseignant; $i++)
        {
            factory(Enseignant::class)->create();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table(Enseignant::NOM_TABLE)->delete();
    }
}
