<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Etudiant;
use App\Modeles\Option;
use App\Modeles\Departement;

class CreerTableEtudiants extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Etudiant::NOM_TABLE, function(Blueprint $table) {
            $table->bigIncrements('id');

            //$table->string(Etudiant::COL_MATRICULE);
            $table->string(Etudiant::COL_NOM);
            $table->string(Etudiant::COL_PRENOM);
            $table->string(Etudiant::COL_EMAIL);
            //$table->string(Etudiant::COL_CIVILITE);
            //$table->date(Etudiant::COL_INSCRIPTION);
            //$table->string(Etudiant::COL_NATIONALITE);
            //$table->string(Etudiant::COL_FORMATION);
            //$table->string(Etudiant::COL_MASTER);
            //$table->string(Etudiant::COL_DIPLOME);
            $table->unsignedSmallInteger(Etudiant::COL_ANNEE);
            $table->boolean(Etudiant::COL_MOBILITE);
            $table->string(Etudiant::COL_PROMOTION);

            $table->unsignedBigInteger(Etudiant::COL_DEPARTEMENT_ID);
            $table->unsignedBigInteger(Etudiant::COL_OPTION_ID);

            $table->foreign(Etudiant::COL_DEPARTEMENT_ID)->references('id')->on(Departement::NOM_TABLE);
            $table->foreign(Etudiant::COL_OPTION_ID)->references('id')->on(Option::NOM_TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Etudiant::NOM_TABLE);
    }
}
