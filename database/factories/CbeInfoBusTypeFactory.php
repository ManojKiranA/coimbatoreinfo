<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CbeInfoBusType::class, function (Faker $faker) {
    return [
        'bus_type_name' => $faker->country,
        'created_by' => function() { return \App\Models\User::inRandomOrder()->first()->id; },
        'created_at' => now(),

    ];
});