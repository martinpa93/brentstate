<?php

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
       /*  'email' => $faker->unique()->safeEmail, */
        'email'=>'priprueba@email.com',
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Property::class, function (Faker $faker) {
    return [
        /* 'user_id' => factory('App\User')->create()->id, */
        'cref' => str_random(20),
        'address' => $faker->address,
        'population' => $faker->state(), 
        'province' => $faker->state(),
        'cp' => $faker->numberBetween(1000,53000),
        'type' => $faker->randomElement(['Vivienda', 'Local comercial', 'Garaje']),
        'm2' => $faker->numberBetween(0,200),
        'nroom' => $faker->numberBetween(0,10),
        'nbath' => $faker->numberBetween(0,3),
        'created_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
    ];
});

$factory->define(App\Renter::class, function (Faker $faker) {
    return [
        /* 'user_id'=>factory('App\User')->create()->id, */
        'dni' => str_random(9),
        'name' => $faker->firstName,
        'surname' => $faker->lastName,
        'dbirth' => $faker->dateTime(),
        'address' => $faker->address,
        'cp' => $faker->numberBetween(1000,53000),
        'population' => $faker->state(),
        'phone' => $faker->numberBetween(600000000,700000000),
        'iban' => $faker->iban('ES','ES',null),
        'job' => $faker->jobtitle,
        'created_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
    ];
});

$factory->define(App\Contract::class, function (Faker $faker) {
    return [
        /* 'user_id'=>factory('App\User')->create()->id,
        'property_id'=>factory('App\Property')->create()->cref,
        'renter_id'=>factory('App\Renter')->create()->dni, */
        'dstart' => $faker->dateTime(),
        'dend' => $faker->dateTime(),
        'created_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s'),
        'updated_at' => $faker->dateTimeThisMonth()->format('Y-m-d H:i:s')
    ];
});
