<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

use App\Modeles\Contact;
use App\Modeles\Enseignant;
use App\Modeles\Departement;
use App\Modeles\Option;
use App\Utils\Constantes;

$factory->define(Contact::class, function (Faker $faker)
{
    return [
        'nom'       => $faker->firstName,
        'prenom'    => $faker->lastName,
        'civilite'  => $faker->randomElement(Constantes::CIVILITE),
        'type'      => $faker->randomElement(Constantes::TYPE_CONTACT),
        'email'     => $faker->unique()->safeEmail,
        'telephone' => $faker->phoneNumber,
        'adresse'   => $faker->address
    ];
});

$factory->define(Enseignant::class, function (Faker $faker)
{
    $idDepartements = DB::table(Departement::NOM_TABLE)->pluck('id');
    $idOptions      = DB::table(Option::NOM_TABLE)->pluck('id');

    return [
        Enseignant::COL_NOM                        => $faker->firstname,
        Enseignant::COL_PRENOM                     => $faker->lastName,
        Enseignant::COL_EMAIL                      => $faker->unique()->safeEmail,
        Enseignant::COL_RESPONSABLE_DEPARTEMENT_ID => $faker->randomElement($idDepartements),
        Enseignant::COL_RESPONSABLE_OPTION_ID      => $faker->randomElement($idOptions)
    ];
});