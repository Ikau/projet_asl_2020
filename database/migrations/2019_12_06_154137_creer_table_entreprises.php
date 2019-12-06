<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Entreprise;

class CreerTableEntreprises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Entreprise::NOM_TABLE, function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nom');
            $table->text('adresse');
            $table->text('adresse2');
            $table->string('cp');
            $table->string('ville');
            $table->string('region');
            $table->string('pays');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Entreprise::NOM_TABLE);
    }
}
