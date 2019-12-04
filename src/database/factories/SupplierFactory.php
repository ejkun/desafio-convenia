<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Supplier;
use Faker\Generator as Faker;

$factory->define(Supplier::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'monthlyPayment' => $faker->numberBetween(100, 1000),
        'active' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});

$factory->state(Supplier::class, 'active', [
    'active' => true,
]);
