<?php

namespace Tests;

use App\Modeles\Enseignant;
use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Role;

use App\User;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Schema;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;


    /* ====================================================================
     *                          TESTS MODELES
     *
     * Les fonctions listees ici sont surtout utilisees dans les classes
     * de tests unitaires des modeles.
     *
     * On pourrait tester toutes les classes ici mais puisque les classes
     * peuvent evoluer, on garde la convention 'un fichier == une classe'
     * ====================================================================
     */
    /**
     * Verifie que les attributs du model par defaut correspondent bien aux attentes
     *
     * @param array $attributsDefaut Les attributs par defaut attendus (ID exclu)
     * @param Model $modele Le modele de la classe Eloquent a tester
     * @param string $nomTable Le nom de la table dans la base de donnees
     * @param int $compteur Compteur egale a 1 si ID suppose inclus ou 0 sinon
     */
    function verifieIntegriteConstructeurEloquent(Array $attributsDefaut, Model $modele, string $nomTable, int $compteur = 1)
    {
        // Integrite du constructeur
        foreach($attributsDefaut as $clef => $valeur)
        {
            self::assertEquals($valeur, $modele[$clef]);
            $compteur++;
        }

        // Integrite du nombre des attributs
        $nbAttributs = count(Schema::getColumnListing($nomTable));
        self::assertEquals($nbAttributs, $compteur);
    }

    /**
     * Verifie que les deux fiches entrees en argument sont les meme (par rapport au contenu
     *
     * @param FicheRapport $ficheTemoin
     * @param FicheRapport $ficheTest
     */
    function assertFichesRapportEgales(FicheRapport $ficheTemoin, FicheRapport $ficheTest)
    {
        $attributs = Schema::getColumnListing(FicheRapport::NOM_TABLE);
        foreach($attributs as $attribut)
        {
            $this->assertEquals($ficheTemoin[$attribut], $ficheTest[$attribut]);
        }
    }

    /* ====================================================================
     *                          FONCTIONS PRIVEES
     * ====================================================================
     */

    /**
     * Fonction auxiliaire permettant de creer un compte user avec le role 'enseignant'
     * Le compte user est lie a un compte enseignant valide
     *
     * @return App\User
     */
    function creerUserRoleEnseignant()
    {
        // Creation d'un enseignant permis
        $enseignant = factory(Enseignant::class)->create();

        // Creation de l'utilisteur associe
        $user = User::fromEnseignant($enseignant->id, 'azerty');

        // Ajout du role 'referent'
        $roleEnseignant = Role::where(Role::COL_INTITULE, '=', Role::VAL_ENSEIGNANT)->first();
        $user->roles()->attach($roleEnseignant);
        $user->save();

        return $user;
    }

    /**
     * Ajoute le role 'responsable_option' a l'utilisateur entre en argument
     */
    function ajouteRoleResponsableDepartement(User $user)
    {
        // Recuperation du role 'responsable_departement'
        $roleResponsableDepartement = Role::where(Role::COL_INTITULE, '=', Role::VAL_RESP_DEPARTEMENT)->first();

        // Ajout du role a l'utilisateur
        $user->roles()->attach($roleResponsableDepartement);
        $user->save();
    }
}
