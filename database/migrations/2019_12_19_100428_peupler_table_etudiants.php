<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Etudiant;

class PeuplerTableEtudiants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $nbEtudiant = 15;
        for($i=0; $i<$nbEtudiant; $i++)
        {
            factory(Etudiant::class)->create();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table(Etudiant::NOM_TABLE)->delete();
    }
}
