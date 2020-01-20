<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Modeles\Stage;
use App\Modeles\Enseignant;
use App\Modeles\Etudiant;

class InsererAffectations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Stages precis
        $this->insertAffectationsBobDupont();
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

    /**
     * Cree des affectations de stage pour l'enseignant Bob Dupont
     * 
     * @return void
     */
    private function insertAffectationsBobDupont()
    {
        // Recuperation de l'enseignant Bob Dupont
        $bobDupont = Enseignant::where(Enseignant::COL_EMAIL, '=', 'dupont.bob@exemple.fr')->first();

        $nbStages = 10;
        for($i=0; $i<$nbStages; $i++)
        {
            $etudiant                      = factory(Etudiant::class)->create();
            $stage                         = factory(Stage::class)->make();
            $stage[Stage::COL_ETUDIANT_ID] = $etudiant->id;
            $stage[Stage::COL_REFERENT_ID] = $bobDupont->id;
            $stage->save();
        }
    }
}
