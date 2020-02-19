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
        // C'est moche mais j'ai rien de mieux
        $idDepartementVide = Departement::where(Departement::COL_INTITULE, '=', Departement::VAL_AUCUN)->first()->id;
        $idOptionVide      = Option::where(Option::COL_INTITULE, '=', Option::VAL_AUCUN)->first()->id;

        $enseignantVide = new Enseignant();
        $enseignantVide->fill([
            Enseignant::COL_NOM                        => '* Aucun',
            Enseignant::COL_PRENOM                     => '',
            Enseignant::COL_EMAIL                      => '',
            Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID => $idDepartementVide,
            Enseignant::COL_RESPONSABLE_OPTION_ID      => $idOptionVide
        ])->save();

        $nbEnseignant = 5;
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
