<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CbeInfoLocationTo::class, function (Faker $faker) {
    return [
        'location_to_name' => $faker->country,
        'created_by' => function() { return \App\Models\User::inRandomOrder()->first()->id; },
        'created_at' => now(),

    ];
});
