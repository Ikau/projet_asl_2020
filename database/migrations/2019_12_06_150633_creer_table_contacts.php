<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Contact;

class CreerTableContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(Contact::NOM_TABLE, function(Blueprint $table) {
            $table->bigIncrements('id');

            $table->string(Contact::COL_NOM);
            $table->string(Contact::COL_PRENOM);
            $table->unsignedSmallInteger(Contact::COL_CIVILITE);
            $table->unsignedSmallInteger(Contact::COL_TYPE);
            $table->string(Contact::COL_EMAIL)->unique();
            $table->string(Contact::COL_TELEPHONE);
            $table->text(Contact::COL_ADRESSE);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists(Contact::NOM_TABLE);
    }
}
