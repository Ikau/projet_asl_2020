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
        $this->insereOptionsMRI();
        $this->insereOptionsSTI();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Supression brutale
        DB::table(Option::NOM_TABLE)->delete();
    }


    /* ====================================================================
     *                          FONCTIONS PRIVEES
     * ====================================================================
     */
    private function insereOptionsMRI()
    {
        $idDepartementMRI = DB::table(Departement::NOM_TABLE)
            ->where(Departement::COL_INTITULE, Departement::VAL_MRI)
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
    }

    private function insereOptionsSTI()
    {
        $idDepartementSTI = DB::table(Departement::NOM_TABLE)
            ->where(Departement::COL_INTITULE, Departement::VAL_STI)
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
}
