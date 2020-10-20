<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Modeles\Contact;
use App\Utils\Constantes;

class PeuplerTableContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Ajout de contacts aleatoires
        $nbContact = 5;
        for($i=0; $i<$nbContact; $i++)
        {
            factory(Contact::class)->create();
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table(Contact::NOM_TABLE)->delete();
    }
}
