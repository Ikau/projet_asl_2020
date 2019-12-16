<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use Faker\Generator as Faker;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

use App\Utils\Constantes;

$factory->define(\App\Modeles\Contact::class, function (Faker $faker)
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

$factory->define(\App\Modeles\Enseignant::class, function (Faker $faker)
{
    return [
        'nom'                     => $faker->firstname,
        'prenom'                  => $faker->lastName,
        'email'                   => $faker->unique()->safeEmail,
        'responsable_option'      => $faker->randomElement(array_merge(
            Constantes::OPTION['vide'],
            Constantes::OPTION['MRI'],
            Constantes::OPTION['STI'],
        )),
        'responsable_departement' => $faker->randomElement(Constantes::DEPARTEMENT)
    ];
});