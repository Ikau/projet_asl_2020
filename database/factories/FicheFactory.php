<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modeles\Fiches\FicheRapport;
use App\Modeles\Fiches\FicheSynthese;
use App\Modeles\Fiches\ModeleNotation;
use App\Modeles\Fiches\Section;
use App\Modeles\Stage;
use App\Utils\Constantes;
use Faker\Generator as Faker;

$factory->define(FicheRapport::class, function (Faker $faker)
{
    // Recuperation d'un modele existant
    $modele = ModeleNotation::orderBy(ModeleNotation::COL_VERSION, 'desc')
        ->get()
        ->first();

    return [
        // Attributs propres au modele
        FicheRapport::COL_APPRECIATION => $faker->text,
        FicheRapport::COL_CONTENU      => [],
        FicheRapport::COL_STATUT       => FicheRapport::VAL_STATUT_NOUVELLE,

        // Clefs etrangeres_
        FicheRapport::COL_MODELE_ID   => $modele->id,
        FicheRapport::COL_STAGE_ID    => factory(Stage::class)->create()->id,
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

$factory->define(Section::class, function (Faker $faker)
{
    return [
        Section::COL_CHOIX     => factory(Constantes::FACTORY_CHOIX_SECTION)->raw(),
        Section::COL_CRITERES  => factory(Constantes::FACTORY_CRITERES_SECTION)->raw(),
        Section::COL_INTITULE  => $faker->words(5),
        Section::COL_MODELE_ID => Constantes::ID_VIDE,
        Section::COL_ORDRE     => Constantes::INT_VIDE // Peut etre override a la creation
    ];
});


/* ====================================================================
 *                       FACTORY CLASSES AUXILIAIRES
 * ====================================================================
 */

/**
 * Renvoie un array representant une instance de choix pour la variante 1 du modele 1
 *
 * La forme de l'array suit le format :
 * array(
 *    index_choix => array(points_float, intitule),
 *    ...
 *    index_choix => array(points_float, intitule)
 * )
 */
$factory->define(Constantes::FACTORY_CHOIX_SECTION, function (Faker $faker)
{
    $choix = [];

    for($i=0; $i<$faker->randomElement([3, 4, 5, 6]); $i++)
    {
        $choix[$i] = [
            $faker->randomFloat(1, 0, 3),
            $faker->words(3)
        ];
    }

    return $choix;
});


/**
 * Renvoie un array de string ou chaque index contient un critere d'evaluation
 *
 * La forme de l'array finale est implement :
 * array(
 *    'mon texte decrivant le critere',
 *    ...,
 *    'mon texte decrivant le critere'
 * )
 */
$factory->define(Constantes::FACTORY_CRITERES_SECTION, function (Faker $faker)
{
    $criteres = [];

    for($i=0; $i<$faker->randomElement([2, 3, 4, 5]); $i++)
    {
        $criteres[] = $faker->sentence;
    }

    return $criteres;
});
