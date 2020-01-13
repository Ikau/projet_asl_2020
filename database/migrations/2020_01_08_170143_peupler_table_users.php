<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Modeles\Contact;
use App\Modeles\Enseignant;

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

        // Creation de comptes aleatoires
        $nbUsers = 20;
        for($i=0; $i<$nbUsers; $i++)
        {
            // Creation d'un enseignant aleatoire
            $enseignant = factory(Enseignant::class)->create();

            // Creation du compte user associe
            $user = factory(User::class)->make();
            $user[User::COL_EMAIL] = $enseignant[Enseignant::COL_EMAIL];
            $user->userable()->associate($enseignant);
            $user->save();
        }
        
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
