<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\Company;
use Faker\Generator as Faker;

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

$factory->define(Client::class, function (Faker $faker) {

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'personalNumber' => $faker->randomNumber(),
        'phone' => $faker->randomNumber(),
        'company_id' => function () {
            return factory(Company::class)->create()->id;
        },
        'zipcode' => $faker->randomNumber(),
        'address' => $faker->streetAddress(),
        'houseNumber' => $faker->randomNumber(),
        'neighborhood' => $faker->city(),
        'state' => $faker->state(),
        'city' => $faker->city(),
        'complement' => $faker->sentence()
    ];
});
