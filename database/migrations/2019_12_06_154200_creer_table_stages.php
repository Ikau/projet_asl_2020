<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Contact;
use App\Modeles\Enseignant;
use App\Modeles\Entreprise;
use App\Modeles\Etudiant;
use App\Modeles\Soutenance;
use App\Modeles\Stage;

class CreerTableStages extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Stage::NOM_TABLE, function(Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedSmallInteger('annee_etudiant');
            $table->date('date_debut');
            $table->date('date_fin');
            $table->string('sujet');
            $table->boolean('convention_envoyee_entreprise');
            $table->boolean('retour_convention_signee');
            $table->float('gratification');
            $table->smallInteger('nombre_de_semaines');
            $table->string('moyen_recherche_stage');
            $table->unsignedBigInteger(Stage::COL_REFERENT_ID);
            $table->unsignedBigInteger(Stage::COL_ETUDIANT_ID);
            $table->unsignedBigInteger(Stage::COL_ENTREPRISE_ID);
            $table->unsignedBigInteger(Stage::COL_MDS_ID);
            $table->unsignedBigInteger(Stage::COL_SOUTENANCE_ID);

            $table->foreign(Stage::COL_REFERENT_ID)->references('id')->on(Enseignant::NOM_TABLE);
            $table->foreign(Stage::COL_ETUDIANT_ID)->references('id')->on(Etudiant::NOM_TABLE);
            $table->foreign(Stage::COL_ENTREPRISE_ID)->references('id')->on(Entreprise::NOM_TABLE);
            $table->foreign(Stage::COL_MDS_ID)->references('id')->on(Contact::NOM_TABLE);
            $table->foreign(Stage::COL_SOUTENANCE_ID)->references('id')->on(Soutenance::NOM_TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Stage::NOM_TABLE);
    }
}
