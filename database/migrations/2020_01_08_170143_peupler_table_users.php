<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Modeles\Contact;
use App\Modeles\Departement;
use App\Modeles\Enseignant;
use App\Modeles\Option;
use App\Utils\Constantes;

class PeuplerTableUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /* ====================================================================
         *                       USER 'CONTACT ADMIN'
         *            Responsable de l'administration du site web
         * ====================================================================
         */
        // Creation du contact Admin
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

        // Creation d'un compte basique
        $userAdmin = new User;
        $userAdmin->fill([
            User::COL_EMAIL         => 'admin@insa-cvl.fr',
            User::COL_HASH_PASSWORD => Hash::make('admin')
        ]);
        $userAdmin->userable()->associate($contactAdmin);
        $userAdmin->save();

        /* ====================================================================
         *                     USER 'ENSEIGNANT BOB DUPONT'
         *                Enseignant lambda responsable de rien
         * ====================================================================
         */
        // Creation de l'enseignant Bob DUPONT
        $bobDupont = new Enseignant;
        $bobDupont->fill([
            Enseignant::COL_NOM                        => 'Dupont',
            Enseignant::COL_PRENOM                     => 'Bob',
            Enseignant::COL_EMAIL                      => 'dupont.bob@exemple.fr',
            Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID => Departement::where(Departement::COL_INTITULE, '=', 'Aucun')->first()->id,
            Enseignant::COL_RESPONSABLE_OPTION_ID      => Option::where(Option::COL_INTITULE, '=', 'Aucune')->first()->id,
        ])->save();

        // Creation du compte de Bob DUPONT
        $userDupont = new User;
        $userDupont->fill([
            User::COL_EMAIL            => $bobDupont[Enseignant::COL_EMAIL],
            User::COL_HASH_PASSWORD    => Hash::make('azerty'),
        ]);
        $userDupont->userable()->associate($bobDupont);
        $userDupont->save();

        /* ====================================================================
         *                   USER 'SCOLARITE ALICE TOIRE'
         *              Personnel de l'INSA responsable de stages
         * ====================================================================
         */
        // Creation du contact Alice DUBOIS
        $aliceToire = new Contact;
        $aliceToire->fill([
            Contact::COL_NOM       => 'Toire',
            Contact::COL_PRENOM    => 'Alice',
            Contact::COL_CIVILITE  => Constantes::CIVILITE['Madame'],
            Contact::COL_TYPE      => Constantes::TYPE_CONTACT['insa'],
            Contact::COL_EMAIL     => 'dubois.alice@exemple.fr',
            Contact::COL_TELEPHONE => '0123456789',
            Contact::COL_ADRESSE   => 'INSA CVL, Bourges'
        ])->save();

        // Creation du compte d'Alice DUBOIS
        $userToire = new User;
        $userToire->fill([
            User::COL_EMAIL         => $aliceToire[Contact::COL_EMAIL],
            User::COL_HASH_PASSWORD => Hash::make('azerty'),
        ]);
        $userToire->userable()->associate($aliceToire);
        $userToire->save();

        /* ====================================================================
         *                    USERS 'ENSEIGNANTS ALEATOIRES'
         * ====================================================================
         */

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
