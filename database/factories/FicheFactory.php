<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(FicheRapport::class, function (Faker $faker)
{
    return [
        // Attributs propres au modele
        FicheRapport::COL_APPRECIATION => $faker->text,
        FicheRapport::COL_CONTENU      => json_encode([]),

        // Clefs etrangeres_
        FicheRapport::COL_MODELE_ID   => Constantes::ID_VIDE,
        FicheRapport::COL_STAGE_ID    => Constantes::ID_VIDE,
    ];
});

$factory->define(FicheSynthese::class, function (Faker $faker)
{
    return [
        // Attributs propres au modele
        FicheSynthese::COL_COEFFICIENTS => [2, 1, 1],
        FicheSynthese::COL_MODIFIEUR    => $faker->randomElement([-1.0, -0.5, 0.0, 0.5, 1.0]),

        // Clefs etrangeres
        FicheSynthese::COL_STAGE_ID     => Constantes::ID_VIDE,
    ];
});
