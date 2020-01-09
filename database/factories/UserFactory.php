<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Usertype;

use Faker\Generator as Faker;
use Illuminate\Support\Str;

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
    $idsUsertype = Usertype::all()->pluck('id');

    return [
        User::COL_EMAIL            => $faker->unique()->safeEmail,
        User::COL_EMAIL_VERIFIE_LE => now(),
        User::COL_TYPE_ID          => $faker->randomElement($idsUsertype),
        User::COL_HASH_PASSWORD    => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        User::COL_REMEMBER_TOKEN   => Str::random(10),
    ];
});
