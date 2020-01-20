<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Modeles\Stage;
use App\Modeles\Etudiant;

class PeuplerTableStages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $nbEtudiant = DB::table(Etudiant::NOM_TABLE)->count();
        for($i=0; $i<$nbEtudiant; $i++)
        {
            factory(Stage::class)->create();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table(Stage::NOM_TABLE)->delete();
    }
}
