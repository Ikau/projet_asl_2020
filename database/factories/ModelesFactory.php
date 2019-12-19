<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

use App\Modeles\Contact;
use App\Modeles\Enseignant;
use App\Modeles\Etudiant;
use App\Modeles\Departement;
use App\Modeles\Option;
use App\Modeles\Stage;

use App\Utils\Constantes;

$factory->define(Contact::class, function (Faker $faker)
{
    return [
        'nom'       => $faker->lastName,
        'prenom'    => $faker->firstName,
        'civilite'  => $faker->randomElement(Constantes::CIVILITE),
        'type'      => $faker->randomElement(Constantes::TYPE_CONTACT),
        'email'     => $faker->unique()->safeEmail,
        'telephone' => $faker->phoneNumber,
        'adresse'   => $faker->address
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
        Etudiant::COL_OPTION_ID      => $faker->randomElement($idsOption)
    ];
});

$factory->define(Stage::class, function (Faker $faker)
{
    $idsEnseignant = DB::table(Enseignant::NOM_TABLE)->pluck('id');
    $idsEtudiant   = DB::table(Etudiant::NOM_TABLE)->pluck('id');

    return [
        Stage::COL_ANNEE              => $faker->randomElement([4, 5]),
        Stage::COL_CONVENTION_ENVOYEE => $faker->boolean(50),
        Stage::COL_CONVENTION_SIGNEE  => $faker->boolean(50),
        Stage::COL_DATE_DEBUT         => $faker->dateTimeBetween('now', '+3 months'),
        Stage::COL_DATE_FIN           => $faker->dateTimeBetween('+4 months', '+10 months'),

        //$nbMaxDecimals = NULL, $min = 0, $max = NULL
        Stage::COL_DUREE_SEMAINES     => $faker->randomFloat(0, 16, 32),
        Stage::COL_GRATIFICATION      => $faker->randomFloat(2, 0, 2000),

        Stage::COL_INTITULE           => $faker->jobTitle,
        Stage::COL_LIEU               => $faker->city,
        Stage::COL_MOYEN_RECHERCHE    => $faker->domainName,
        Stage::COL_RESUME             => $faker->text,
        
        // Clefs etrangeres
        Stage::COL_REFERENT_ID   => $faker->randomElement($idsEnseignant),
        Stage::COL_ETUDIANT_ID   => $faker->unique()->randomElement($idsEtudiant),
    ];
});