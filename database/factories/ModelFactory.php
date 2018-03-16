<?php

use Illuminate\Support\Facades\Hash;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make('demodemo'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Todo::class, function (Faker\Generator $faker) {
    return [
        'user_id' => App\User::all()->random()->id,
        'name' => 'Task ' . ucwords($faker->words(2, true)),
        'category' => 'demo',
        'description' => $faker->sentence(random_int(5,10))
    ];
});

