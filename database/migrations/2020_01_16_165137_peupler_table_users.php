<?php

use App\Facade\PermissionFacade;
use App\Facade\UserFacade;
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
        // Creation des comptes pour chaque enseignant
        $enseignants = Enseignant::all();
        foreach($enseignants as $enseignant)
        {
            UserFacade::creerDepuisEnseignant($enseignant->id, 'azerty');
        }

        // Insertions de test
        $this->insertAdmin();
        $this->insertEnseignantBernardTichaud();
        $this->insertCharlesAtan();
        $this->insertScolariteAnnieVerserre();
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
            Contact::COL_CIVILITE  => Contact::VAL_CIVILITE_VIDE,
            Contact::COL_TYPE      => Contact::VAL_TYPE_INSA,
            Contact::COL_EMAIL     => 'admin@exemple.fr',
            Contact::COL_TELEPHONE => '',
            Contact::COL_ADRESSE   => '',
        ]);
        $contactAdmin->save();

        // Creation d'un compte basique
        $userAdmin = UserFacade::creerDepuisContact($contactAdmin->id, 'azerty');

        // Ajout des roles et privileges le cas echeant
        PermissionFacade::ajouterRole(Role::VAL_ADMIN, $userAdmin);
    }

    /**
     * Cree un enseignant lambda (responsable de rien) et lui associe un compte user
     *
     * L'enseignant peut etre utilise via la paire 'bernard.tichaud@exemple.fr / azerty'
     * Le role 'referent' lui est attribue mais aucun privileges pour l'instant
     * Des privileges pourraient être ajoutes au fur et a mesure du developpement
     */
    private function insertEnseignantBernardTichaud()
    {
        // Creation de l'enseignant Bob DUPONT
        $bernardTichaud = new Enseignant;
        $bernardTichaud->fill([
            Enseignant::COL_NOM                        => 'Tichaud',
            Enseignant::COL_PRENOM                     => 'Bernard',
            Enseignant::COL_EMAIL                      => 'bernard.tichaud@exemple.fr'
        ])->save();

        // Creation du compte de Bernard TICHAUD
        $userTichaud = UserFacade::creerDepuisEnseignant($bernardTichaud->id, 'azerty');

        // Ajout des roles et des privileges au compte
        PermissionFacade::ajouterRole(Role::VAL_ENSEIGNANT, $userTichaud);
    }

    /**
     * Creer un enseignant responsable de departement MRI
     */
    private function insertCharlesAtan()
    {
        // Creation de l'enseignant Charels Atan
        $charlesAtan = new Enseignant;
        $charlesAtan->fill([
            Enseignant::COL_NOM                        => 'Atan',
            Enseignant::COL_PRENOM                     => 'Charles',
            Enseignant::COL_EMAIL                      => 'charles.atan@exemple.fr'
        ])->save();

        // Affectation en tant que responsable de MRI
        PermissionFacade::remplaceResponsableDepartement(Departement::VAL_MRI, $charlesAtan);

        // Creation du compte de Charles Atan
        $userAtan = UserFacade::creerDepuisEnseignant($charlesAtan->id, 'azerty');

        // Ajout des roles et des privileges au compte
        PermissionFacade::ajouterRole(Role::VAL_ENSEIGNANT, $userAtan);
        PermissionFacade::ajouterRole(Role::VAL_RESP_DEPARTEMENT, $userAtan);
    }

    /**
     * Cree un personnel de l'INSA responsable des stages et lui associe un compte user
     *
     * Le compte est celui d'Annie Verserre, accessible via la paire 'verserre.annie@exemple.fr / azerty'
     * Elle est chargee de gerer les stages (planification et soutenances)
     * On lui associe le role 'scolarite' mais aucun privilege pour l'instant
     *
     * Les privileges seront ajoutes au fur et a mesure du developpement
     *
     */
    private function insertScolariteAnnieVerserre()
    {
        // Creation du contact Annie Verserre
        $annieVerserre = factory(Contact::class)->make();
        $annieVerserre->fill([
            Contact::COL_NOM       => 'Verserre',
            Contact::COL_PRENOM    => 'Annie',
            Contact::COL_CIVILITE  => Contact::VAL_CIVILITE_MONSIEUR,
            Contact::COL_TYPE      => Contact::VAL_TYPE_INSA,
            Contact::COL_EMAIL     => 'annie.verserre@exemple.fr'
        ])->save();

        // Creation du compte d'Annie Verserre
        $userAnnieVerserre = UserFacade::creerDepuisContact($annieVerserre->id, 'azerty');

        // Ajout des roles et des privileges au compte
        PermissionFacade::ajouterRole(Role::VAL_SCOLARITE, $userAnnieVerserre);
    }
}
