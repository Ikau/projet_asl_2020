<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Etudiant;

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
            $table->string('nom');
            $table->string('prenom');
            $table->string('email');
            $table->string('civilite');
            $table->date('inscription');
            $table->string('nationalite');
            $table->string('formation');
            $table->string('option');
            $table->string('master');
            $table->string('diplome');
            $table->unsignedSmallInteger('annee');
            $table->boolean('mobilite');
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
