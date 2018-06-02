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

$factory->define(App\Death::class, function(Faker\Generator $faker) {

    $now = Carbon::now();

    $data = [
        'firstName' => $faker->firstName,
        'middleName' => $faker->lastName,
        'lastName' => $faker->lastName,
        'nameExt' => 'Jr.',
        'deathDate' => $now->toDateString(),
        'burialDate' => $now->toDateString(),
        'residence' => $faker->address,
        'burialPlace' => $faker->address,
        'book' => $faker->numberBetween(1,10),
        'page' => $faker->numberBetween(1,10),
        'entry' => $faker->numberBetween(1,10),
        'minister_id' => $faker->numberBetween(1,10),
    ];

    return $data;

});


$factory->define(App\MarriageHusband::class, function(Faker\Generator $faker) {
    $now = Carbon::now();

    $data = [
        'firstName' => $faker->firstName,
        'middleName' => $faker->lastName,
        'lastName' => $faker->lastName,
        'nameExt' => 'Jr.',
        'birthdate' => $now->toDateString(),
        'religion' => 'Roman Catholic',
        'residence' => $faker->address,
        'fatherName' => $faker->name('male'),
        'motherName' => $faker->name('female')
    ];

    return $data;
});

$factory->define(App\MarriageWife::class, function(Faker\Generator $faker) {
    $now = Carbon::now();

    $data = [
        'firstName' => $faker->firstName,
        'middleName' => $faker->lastName,
        'lastName' => $faker->lastName,
        'birthdate' => $now->toDateString(),
        'religion' => 'Roman Catholic',
        'residence' => $faker->address,
        'fatherName' => $faker->name('male'),
        'motherName' => $faker->name('female')
    ];

    return $data;
});

$factory->define(App\Marriage::class, function(Faker\Generator $faker) {
    $now = Carbon::now();

    $data = [
        'dateMarried' => $now->toDateString(),
        'book' => $faker->numberBetween(1,10),
        'page' => $faker->numberBetween(1,10),
        'entry' => $faker->numberBetween(1,10),
        'minister_id' => $faker->numberBetween(1,10)
    ];

    return $data;
});

$factory->define(App\MarriageSponsor::class, function(Faker\Generator $faker) {

    $now = Carbon::now();

    $data = ['sponsor' => $faker->name, 'created_at' => $now, 'updated_at' => $now];

    return $data;

});

$factory->define(App\ProductCategories::class, function (Faker\Generator $faker) {

    $data = [
        'name' => $faker->title,
        'parent_id' => 0
    ];

    return $data;

});


$factory->define(App\Products::class, function(Faker\Generator $faker) {

    $data = [
        'code' => $faker->randomNumber(),
        'description'  => $faker->title,
        'price' => $faker->randomNumber(2),
        'category_id' => 0

    ];

    return $data;

});


$factory->define(App\Sales::class, function(Faker\Generator $faker) {

    $now = Carbon::now()->toDateString();

    $data = [
        'refNumber' => $faker->numberBetween(1234567, 999999999),
        'dateIssued' => $now];

    return $data;

});

$factory->define(App\SalesProduct::class, function(Faker\Generator $faker) {

    $data = [
        'price' => $faker->numberBetween(1,500),
        'quantity' => $faker->numberBetween(1,10),
        'product_id' => function() {
            return factory(App\Products::class)->create()->id;
        }
    ];

    return $data;

});


$factory->define(App\ExpenseCategories::class, function(Faker\Generator $faker) {

    $now = Carbon::now();

    $data = [
        'name' => $faker->name
    ];

    return $data;

});