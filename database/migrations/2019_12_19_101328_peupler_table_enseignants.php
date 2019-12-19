<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Modeles\Enseignant;
use App\Modeles\Departement;
use App\Modeles\Option;

class PeuplerTableEnseignants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $idAucunDepartement = Departement::where(Departement::COL_INTITULE, 'Aucun')->first()->id;
        $idAucuneOption     = Option::where(Option::COL_INTITULE, 'Aucune')->first()->id;
        // Enseignant vide
        DB::table(Enseignant::NOM_TABLE)->insert([
            'nom'            => '',
            'prenom'         => 'Aucun',
            'email'          => 'aucun@null.com',
            'option_id'      => $idAucuneOption,
            'departement_id' => $idAucunDepartement
        ]);

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
