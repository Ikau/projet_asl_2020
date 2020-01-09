<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Modeles\Contact;

class PeuplerTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Recuperation du contact
        $contactAdmin = Contact::where(Contact::COL_EMAIL, '=', 'admin@insa-cvl.fr')->first();

        // Creation d'un compte basique
        $userAdmin = new User;
        $userAdmin->fill([
            User::COL_EMAIL         => 'admin@insa-cvl.fr',
            User::COL_HASH_PASSWORD => Hash::make('admin')
        ]);
        $userAdmin->userable()->associate($contactAdmin);
        $userAdmin->save();
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table(User::NOM_TABLE)->delete();
    }
}
