<?php

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

use Carbon\Carbon;

$factory->define(App\Ministers::class, function (Faker\Generator $faker) {

    $now = Carbon::now();

    return [
        'id' => 1,
        'name' => $faker->name,
        'active' => 0,
        'created_at' => $now,
        'updated_at' => $now
    ];
});


$factory->define(App\Baptism::class, function(Faker\Generator $faker) {

    $now = Carbon::now();

    $data = [
            'firstName' => $faker->firstName,
            'middleName' => $faker->lastName,
            'lastName' => $faker->lastName,
            'nameExt' => 'Jr.',
            'birthdate' => $now->toDateString(),
            'birthPlace' => $faker->address,
            'baptismDate' => $now->toDateString(),
            'book' => $faker->numberBetween(2,100),
            'page' => $faker->numberBetween(2,100),
            'entry' => $faker->numberBetween(2,100),
            'fatherName' => $faker->name,
            'motherName' => $faker->name,
            'minister_id' => $faker->numberBetween(1,10),
            'created_at' => $now,
            'updated_at' => $now
        ];


     return $data;
});


$factory->define(App\BaptismSponsor::class, function(Faker\Generator $faker) {

    $now = Carbon::now();

    $data = ['sponsor' => $faker->name, 'created_at' => $now, 'updated_at' => $now];

    return $data;

});

$factory->define(App\Confirmation::class, function(Faker\Generator $faker) {

    $now = Carbon::now();

    $data = [
        'firstName' => $faker->firstName,
        'middleName' => $faker->lastName,
        'lastName' => $faker->lastName,
        'nameExt' => 'Jr.',
        'confirmationDate' => $now->toDateString(),
        'baptizedAt' => $faker->address,
        'baptismDate' => $now->toDateString(),
        'book' => $faker->numberBetween(2,100),
        'page' => $faker->numberBetween(2,100),
        'minister_id' => $faker->numberBetween(1,10),
        'created_at' => $now,
        'updated_at' => $now
    ];


    return $data;
});

$factory->define(App\ConfirmationSponsor::class, function(Faker\Generator $faker) {

    $now = Carbon::now();

    $data = ['sponsor' => $faker->name, 'created_at' => $now, 'updated_at' => $now];

    return $data;

});