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

            $table->string(Entreprise::COL_NOM);
            $table->text(Entreprise::COL_ADRESSE);
            $table->text(Entreprise::COL_ADRESSE2);
            $table->string(Entreprise::COL_CP);
            $table->string(Entreprise::COL_VILLE);
            $table->string(Entreprise::COL_REGION);
            $table->string(Entreprise::COL_PAYS);
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
