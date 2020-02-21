<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\Modeles\Departement;
use App\Modeles\Option;

class PeuplerTableOptions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ajout des options pour le departement 'Aucun'
        $idDepartementVide = DB::table(Departement::NOM_TABLE)
        ->where(Departement::COL_INTITULE, 'Aucun')
        ->first()
        ->id;

        DB::table(Option::NOM_TABLE)->insert([
            [
                Option::COL_INTITULE       => 'Aucune',
                Option::COL_DEPARTEMENT_ID => $idDepartementVide
            ],
        ]);

        // Ajout des options pour le departement 'MRI'
        $idDepartementMRI = DB::table(Departement::NOM_TABLE)
        ->where(Departement::COL_INTITULE, 'MRI')
        ->first()
        ->id;

        foreach(['RAI', 'RE', 'RSI', 'SFEN', 'STLR'] as $option)
        {
            DB::table(Option::NOM_TABLE)->insert([
                [
                    Option::COL_INTITULE       => $option,
                    Option::COL_DEPARTEMENT_ID => $idDepartementMRI
                ]
            ]);
        }

        // Ajout des options pour le departement 'STI'
        $idDepartementSTI = DB::table(Departement::NOM_TABLE)
        ->where(Departement::COL_INTITULE, 'STI')
        ->first()
        ->id;

        foreach(['2SU', '4AS', 'ASL'] as $option)
        {
            DB::table(Option::NOM_TABLE)->insert([
                [
                    Option::COL_INTITULE       => $option,
                    Option::COL_DEPARTEMENT_ID => $idDepartementSTI
                ]
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Supression brutale
        DB::table(Option::NOM_TABLE)->truncate();
    }
}
