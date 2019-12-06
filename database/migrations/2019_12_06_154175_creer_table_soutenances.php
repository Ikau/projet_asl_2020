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

            $table->text('commentaire');
            $table->string('invites');
            $table->unsignedSmallInteger('repas');
            $table->string('salle');
            $table->time('heure');
            $table->date('date');
            $table->string('departement_ou_option');
            $table->unsignedSmallInteger('annee_etudiant');
            $table->string('campus');
            $table->boolean('confidentielle');
            $table->unsignedBigInteger(Soutenance::COL_REFERENT_ID);
            $table->unsignedBigInteger(Soutenance::COL_CANDIDE_ID);
            $table->unsignedBigInteger(Soutenance::COL_ETUDIANT_ID);
            $table->unsignedBigInteger(Soutenance::COL_CONTACT_ENTREPRISE_ID);

            $table->foreign(Soutenance::COL_REFERENT_ID)->references('id')->on(Enseignant::NOM_TABLE);
            $table->foreign(Soutenance::COL_CANDIDE_ID)->references('id')->on(Enseignant::NOM_TABLE);
            $table->foreign(Soutenance::COL_ETUDIANT_ID)->references('id')->on(Etudiant::NOM_TABLE);
            $table->foreign(Soutenance::COL_CONTACT_ENTREPRISE_ID)->references('id')->on(Contact::NOM_TABLE);
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
