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

            $table->unsignedSmallInteger(Stage::COL_ANNEE);
            $table->boolean(Stage::COL_CONVENTION_ENVOYEE);
            $table->boolean(Stage::COL_CONVENTION_SIGNEE);
            $table->date(Stage::COL_DATE_DEBUT);
            $table->date(Stage::COL_DATE_FIN);
            $table->smallInteger(Stage::COL_DUREE_SEMAINES);
            $table->float(Stage::COL_GRATIFICATION, 10, 2);
            $table->string(Stage::COL_INTITULE);
            $table->string(Stage::COL_LIEU);
            $table->string(Stage::COL_MOYEN_RECHERCHE);
            $table->text(Stage::COL_RESUME);

            $table->unsignedBigInteger(Stage::COL_REFERENT_ID);
            $table->unsignedBigInteger(Stage::COL_ETUDIANT_ID);
            //$table->unsignedBigInteger(Stage::COL_ENTREPRISE_ID);
            //$table->unsignedBigInteger(Stage::COL_MDS_ID);

            $table->foreign(Stage::COL_REFERENT_ID)->references('id')->on(Enseignant::NOM_TABLE);
            $table->foreign(Stage::COL_ETUDIANT_ID)->references('id')->on(Etudiant::NOM_TABLE);
            //$table->foreign(Stage::COL_ENTREPRISE_ID)->references('id')->on(Entreprise::NOM_TABLE);
            //$table->foreign(Stage::COL_MDS_ID)->references('id')->on(Contact::NOM_TABLE);
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
