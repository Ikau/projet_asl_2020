<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(User::class, function (Faker $faker) {

    return [
        User::COL_EMAIL            => $faker->unique()->safeEmail,
        User::COL_EMAIL_VERIFIE_LE => now(),
        User::COL_HASH_PASSWORD    => Hash::make($faker->word), // password
        User::COL_REMEMBER_TOKEN   => Str::random(10),
    ];
});
