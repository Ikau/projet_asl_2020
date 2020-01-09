<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

use App\UserType;

class PeuplerTableUsertypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // WIP : ecriture en brute pour l'instant, utiliser un fichier de config plus tard
        $types = [
            'Invite',
            'Admin',
            'Enseignant',
            'Scolarite',
            'Contact'
        ];

        foreach($types as $type)
        {
            $nouveauType = new UserType;
            $nouveauType[UserType::COL_INTITULE] = $type;
            $nouveauType->save();
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table(UserType::NOM_TABLE)->delete();
    }
}
