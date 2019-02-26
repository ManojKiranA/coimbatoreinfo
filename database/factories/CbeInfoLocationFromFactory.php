<?php

use Faker\Generator as Faker;

$factory->define(App\Models\CbeInfoLocationFrom::class, function (Faker $faker) {
	
    return [
        'location_from_name' => $faker->country,
        'created_by' => function() { return \App\Models\User::inRandomOrder()->first()->id; },
        'created_at' => now(),

    ];
});
