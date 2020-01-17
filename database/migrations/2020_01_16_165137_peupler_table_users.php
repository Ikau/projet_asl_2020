<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Modeles\Contact;
use App\Modeles\Departement;
use App\Modeles\Enseignant;
use App\Modeles\Privilege;
use App\Modeles\Option;
use App\Modeles\Role;
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
        // Insertions de test
        $this->insertAdmin();
        $this->insertEnseignantBobDupont();
        $this->insertScolariteAliceToire();

        // Creation de comptes aleatoires
        $nbUsers = 20;
        for($i=0; $i<$nbUsers; $i++)
        {
            // Creation d'un enseignant aleatoire
            $enseignant = factory(Enseignant::class)->create();

            // Creation du compte user associe
            $user = factory(User::class)->make();
            $user[User::COL_EMAIL] = $enseignant[Enseignant::COL_EMAIL];
            $user->identite()->associate($enseignant);
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

    /* ====================================================================
     *                        FONCTION AUXILIAIRES
     * ====================================================================
     */

    /**
     * Cree un contact de type 'Admin' et cree un compte associe a ce contact 
     * 
     * Ce compte peut etre utilise via la paire de login 'admin@exemple.fr / azerty'
     * La fonction lui associe le role 'admin'
     * Pour l'instant, aucun privilege n'est donne a ce compte car le besoin de fragmenter
     * le role de l'admin ne s'est pas encore fait ressentir
     * 
     * @return void
     */
    private function insertAdmin()
    {
        // Creation du contact Admin
        $contactAdmin = new Contact;
        $contactAdmin->fill([
            Contact::COL_NOM       => 'admin',
            Contact::COL_PRENOM    => 'admin',
            Contact::COL_CIVILITE  => Constantes::CIVILITE['vide'],
            Contact::COL_TYPE      => Constantes::TYPE_CONTACT['insa'],
            Contact::COL_EMAIL     => 'admin@exemple.fr',
            Contact::COL_TELEPHONE => '',
            Contact::COL_ADRESSE   => '',
        ]);
        $contactAdmin->save();

        // Creation d'un compte basique
        $userAdmin = User::fromContact($contactAdmin->id, 'azerty');

        // Ajout des roles et privileges le cas echeant
        $roleAdmin = Role::where(Role::COL_INTITULE, '=', Role::VAL_ADMIN)->first();
        $userAdmin->roles()->attach($roleAdmin);
        $userAdmin->save();
    }

    /**
     * Cree un enseignant lambda (responsable de rien) et lui associe un compte user
     * 
     * L'enseignant peut etre utilise via la paire 'dupont.bob@exemple.fr / azerty'
     * Le role 'referent' lui est attribue mais aucun privileges pour l'instant
     * Des privileges seront ajoutes au fur et a mesure du developpement
     */
    private function insertEnseignantBobDupont()
    {
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
        $userDupont = User::fromEnseignant($bobDupont->id, 'azerty');

        // Ajout des roles et des privileges au compte
        $roleEnseignant = Role::where(Role::COL_INTITULE, '=', Role::VAL_ENSEIGNANT)->first();
        $userDupont->roles()->attach($roleEnseignant);
        $userDupont->save();
    }

    /**
     * Cree un personnel de l'INSA responsable des stages et lui associe un compte user
     * 
     * Le compte est celui d'Alice TOIRE, accessible via la paire 'toire.alice@exemple.fr / azerty'
     * Elle est chargee de gerer les stages (planification et soutenances)
     * On lui associe le role 'scolarite' mais aucun privilege pour l'instant
     * 
     * Les privileges seront ajoutes au fur et a mesure du developpement
     * 
     */
    private function insertScolariteAliceToire()
    {
        // Creation du contact Alice DUBOIS
        $aliceToire = new Contact;
        $aliceToire->fill([
            Contact::COL_NOM       => 'Toire',
            Contact::COL_PRENOM    => 'Alice',
            Contact::COL_CIVILITE  => Constantes::CIVILITE['Madame'],
            Contact::COL_TYPE      => Constantes::TYPE_CONTACT['insa'],
            Contact::COL_EMAIL     => 'toire.alice@exemple.fr',
            Contact::COL_TELEPHONE => '0123456789',
            Contact::COL_ADRESSE   => 'INSA CVL, Bourges'
        ])->save();

        // Creation du compte d'Alice DUBOIS
        $userToire = User::fromContact($aliceToire->id, 'azerty');

        // Ajout des roles et des privileges au compte
        $roleScolarite = Role::where(Role::COL_INTITULE, '=', Role::VAL_SCOLARITE)->first();
        $userToire->roles()->attach($roleScolarite);
        $userToire->save();
    }
}
