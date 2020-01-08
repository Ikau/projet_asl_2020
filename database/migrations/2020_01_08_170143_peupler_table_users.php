<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\TypeUser;

class PeuplerTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Recuperation des types
        $idTypeAdmin = TypeUser::where(TypeUser::COL_INTITULE, '=', 'Admin')->first()->id;

        // Creation d'un compte basique
        DB::table(User::NOM_TABLE)->insert([
            User::COL_EMAIL         => 'admin@insa-cvl.fr',
            User::COL_HASH_PASSWORD => Hash::make('admin'),
            User::COL_TYPE_ID       => $idTypeAdmin
        ]);
        
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
