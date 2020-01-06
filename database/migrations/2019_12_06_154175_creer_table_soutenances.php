<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Contact;
use App\Modeles\Enseignant;
use App\Modeles\Etudiant;
use App\Modeles\Soutenance;

class CreerTableSoutenances extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Soutenance::NOM_TABLE, function(Blueprint $table) {
            $table->bigIncrements('id');

            // Colonnes
            $table->unsignedSmallInteger(Soutenance::COL_ANNEE_ETUDIANT);
            $table->string(Soutenance::COL_CAMPUS);
            $table->text(Soutenance::COL_COMMENTAIRE);
            $table->boolean(Soutenance::COL_CONFIDENTIELLE);
            $table->date(Soutenance::COL_DATE);
            $table->time(Soutenance::COL_HEURE);
            $table->string(Soutenance::COL_INVITES);
            $table->unsignedSmallInteger(Soutenance::COL_NB_REPAS);
            $table->string(Soutenance::COL_OPTION_ETUDIANT);
            $table->string(Soutenance::COL_SALLE);

            // Clefs etrangeres
            $table->unsignedBigInteger(Soutenance::COL_CANDIDE_ID);
            $table->unsignedBigInteger(Soutenance::COL_CONTACT_ENTREPRISE_ID);
            $table->unsignedBigInteger(Soutenance::COL_ETUDIANT_ID);
            $table->unsignedBigInteger(Soutenance::COL_REFERENT_ID);

            $table->foreign(Soutenance::COL_CANDIDE_ID)->references('id')->on(Enseignant::NOM_TABLE);
            $table->foreign(Soutenance::COL_CONTACT_ENTREPRISE_ID)->references('id')->on(Contact::NOM_TABLE);
            $table->foreign(Soutenance::COL_ETUDIANT_ID)->references('id')->on(Etudiant::NOM_TABLE);
            $table->foreign(Soutenance::COL_REFERENT_ID)->references('id')->on(Enseignant::NOM_TABLE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Soutenance::NOM_TABLE);
    }
}
