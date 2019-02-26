<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CbeInfoBusName::class, function (Faker $faker) {
    return [
        'bus_name' => $faker->name,
        'created_by' => function() { return \App\Models\User::inRandomOrder()->first()->id; },
        'created_at' => now(),

    ];
});