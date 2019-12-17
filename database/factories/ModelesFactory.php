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
        Etudiant::COL_ANNEE          => RandomElement([4,5]),
        Etudiant::COL_MOBILITE       => $faker->boolean(50),
        Etudiant::COL_DEPARTEMENT_ID => $faker->randomElement($idsDepartement),
        Etudiant::COL_OPTION_ID      => $faker->randomElement($idsOption)
    ];
});