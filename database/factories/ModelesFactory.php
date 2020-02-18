<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Facade\UserFacade;
use App\User;
use Faker\Generator as Faker;

use App\Modeles\Contact;
use App\Modeles\Enseignant;
use App\Modeles\Entreprise;
use App\Modeles\Etudiant;
use App\Modeles\Departement;
use App\Modeles\Option;
use App\Modeles\Privilege;
use App\Modeles\Stage;
use App\Modeles\Soutenance;

use App\Utils\Constantes;

$factory->define(Contact::class, function (Faker $faker)
{
    return [
        Contact::COL_NOM       => $faker->lastName,
        Contact::COL_PRENOM    => $faker->firstName,
        Contact::COL_CIVILITE  => $faker->randomElement(Constantes::CIVILITE),
        Contact::COL_TYPE      => $faker->randomElement(Constantes::TYPE_CONTACT),
        Contact::COL_EMAIL     => $faker->unique()->safeEmail,
        Contact::COL_TELEPHONE => $faker->phoneNumber,
        Contact::COL_ADRESSE   => $faker->address
    ];
});

$factory->define(Enseignant::class, function (Faker $faker)
{
    $idsDepartement = DB::table(Departement::NOM_TABLE)->pluck('id');
    $idsOption      = DB::table(Option::NOM_TABLE)->pluck('id');

    return [
        Enseignant::COL_NOM                        => $faker->lastName,
        Enseignant::COL_PRENOM                     => $faker->firstname,
        Enseignant::COL_EMAIL                      => $faker->unique()->safeEmail,
        Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID => $faker->randomElement($idsDepartement),
        Enseignant::COL_RESPONSABLE_OPTION_ID      => $faker->randomElement($idsOption)
    ];
});

$factory->define(Etudiant::class, function (Faker $faker)
{
    $idsDepartement = DB::table(Departement::NOM_TABLE)->pluck('id');
    $idsOption      = DB::table(Option::NOM_TABLE)->pluck('id');

    return [
        Etudiant::COL_NOM            => $faker->lastName,
        Etudiant::COL_PRENOM         => $faker->firstName,
        Etudiant::COL_EMAIL          => $faker->unique()->safeEmail,
        Etudiant::COL_ANNEE          => $faker->randomElement([4,5]),
        Etudiant::COL_MOBILITE       => $faker->boolean(50),
        Etudiant::COL_DEPARTEMENT_ID => $faker->randomElement($idsDepartement),
        Etudiant::COL_OPTION_ID      => $faker->randomElement($idsOption),
        Etudiant::COL_PROMOTION      => $faker->randomElement(['2020', '2021'])
    ];
});

$factory->define(Entreprise::class, function (Faker $faker)
{
    return [
        Entreprise::COL_NOM      => $faker->company,
        Entreprise::COL_ADRESSE  => $faker->address,
        Entreprise::COL_ADRESSE2 => $faker->address,
        Entreprise::COL_CP       => $faker->postcode,
        Entreprise::COL_VILLE    => $faker->city,
        Entreprise::COL_REGION   => $faker->region,
        Entreprise::COL_PAYS     => $faker->country,
    ];
});

$factory->define(Privilege::class, function (Faker $faker)
{
    return [
        Privilege::COL_INTITULE => $faker->jobTitle,
    ];
});

$factory->define(Stage::class, function (Faker $faker)
{
    // Creation des entites auxiliaires
    $idEtudiant   = factory(Etudiant::class)->create();

    $enseignant = factory(Enseignant::class)->create();
    UserFacade::creerDepuisEnseignant($enseignant->id, 'azerty');


    return [
        Stage::COL_ANNEE              => $faker->randomElement([4, 5]),
        Stage::COL_CONVENTION_ENVOYEE => $faker->boolean(50),
        Stage::COL_CONVENTION_SIGNEE  => $faker->boolean(50),
        Stage::COL_DATE_DEBUT         => $faker->dateTimeBetween('now', '+3 months')->format('Y-m-d'),
        Stage::COL_DATE_FIN           => $faker->dateTimeBetween('+4 months', '+10 months')->format('Y-m-d'),

        //$nbMaxDecimals = NULL, $min = 0, $max = NULL
        Stage::COL_DUREE_SEMAINES     => $faker->randomFloat(0, 16, 32),
        Stage::COL_GRATIFICATION      => $faker->randomFloat(2, 0, 2000),

        Stage::COL_INTITULE           => $faker->jobTitle,
        Stage::COL_LIEU               => $faker->city,
        Stage::COL_MOYEN_RECHERCHE    => $faker->domainName,
        Stage::COL_RESUME             => $faker->text,

        // Clefs etrangeres
        Stage::COL_REFERENT_ID   => $enseignant->id,
        Stage::COL_ETUDIANT_ID   => $idEtudiant
    ];
});

$factory->define(Soutenance::class, function (Faker $faker)
{
    //$idsContact     = DB::table(Contact::NOM_TABLE)->pluck('id');
    $idsDepartement = DB::table(Departement::NOM_TABLE)->pluck('id');
    $idsEnseignant  = DB::table(Enseignant::NOM_TABLE)->pluck('id');
    $idsEtudiant    = DB::table(Etudiant::NOM_TABLE)->pluck('id');
    $idsOption      = DB::table(Option::NOM_TABLE)->pluck('id');

    return [
        Soutenance::COL_ANNEE_ETUDIANT  => $faker->randomElement([4,5]),
        Soutenance::COL_CAMPUS          => $faker->randomElement(['Bourges', 'Blois']),
        Soutenance::COL_COMMENTAIRE     => $faker->text,
        Soutenance::COL_CONFIDENTIELLE  => $faker->boolean(50),
        Soutenance::COL_DATE            => $faker->dateTimeBetween('+4 months', '+10 months')->format('Y-m-d'),
        Soutenance::COL_HEURE           => $faker->time('H:i:00'),
        Soutenance::COL_INVITES         => $faker->randomElement(["$faker->firstName $faker->lastName", '']),
        Soutenance::COL_NB_REPAS        => $faker->randomElement([0, 1, 2, 3]),
        Soutenance::COL_SALLE           => $faker->randomElement(['SA.101', 'SA.201', 'E.101', 'E.201']),

        // Clefs etrangeres
        Soutenance::COL_CANDIDE_ID             => $faker->randomElement($idsEnseignant),
        //Soutenance::COL_CONTACT_ENTREPRISE_ID  => $faker->randomElement($idsContact),
        Soutenance::COL_DEPARTEMENT_ID         => $faker->randomElement($idsDepartement),
        Soutenance::COL_ETUDIANT_ID            => $faker->randomElement($idsEtudiant),
        Soutenance::COL_OPTION_ID              => $faker->randomElement($idsOption),
        Soutenance::COL_REFERENT_ID            => $faker->randomElement($idsEnseignant),
    ];
});
