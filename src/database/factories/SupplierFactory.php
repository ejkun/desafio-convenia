<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Supplier;
use Faker\Generator as Faker;

$factory->define(Supplier::class, function (Faker $faker) {
    return [
        'nome' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'mensalidade' => $faker->numberBetween(100,1000),
        'ativo' => false,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});

$factory->state(Supplier::class,'active',[
    'ativo' => true
]);
