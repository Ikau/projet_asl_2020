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
        // Creation d'un contact admin
        $contactAdmin = new Contact;
        $contactAdmin->fill([
            Contact::COL_NOM       => 'admin',
            Contact::COL_PRENOM    => 'admin',
            Contact::COL_CIVILITE  => Constantes::CIVILITE['vide'],
            Contact::COL_TYPE      => Constantes::TYPE_CONTACT['insa'],
            Contact::COL_EMAIL     => 'admin@insa-cvl.fr',
            Contact::COL_TELEPHONE => '',
            Contact::COL_ADRESSE   => '',
        ]);
        $contactAdmin->save();

        // Ajout de contacts aleatoires
        $nbContact = 20;
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
