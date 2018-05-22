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

