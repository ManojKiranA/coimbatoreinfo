<?php

use Faker\Generator as Faker;


use App\Models\CbeInfoLocationFrom;
use App\Models\CbeInfoLocationTo;
use App\Models\CbeInfoBusVia;
use App\Models\CbeInfoBusType;
use App\Models\CbeInfoBusName;
use Illuminate\Support\Arr;

date_default_timezone_set('Asia/Calcutta');

$timingArray = ['01:00 AM','02:00 AM','03:00 AM','04:00 AM','05:00 AM','06:00 AM','07:00 AM','08:00 AM','09:00 AM','10:00 AM','11:00 AM','12:00 PM','01:00 PM','02:00 PM','03:00 PM','04:00 PM','05:00 PM','06:00 PM','07:00 PM','08:00 PM','09:00 PM','10:00 PM','11:00 PM','12:00 AM'];

$factory->define(App\Models\CbeInfoBusTiming::class, function (Faker $faker) use ($timingArray) {
    return [
        'bus_id' => function() { return \App\Models\CbeInfoBusName::inRandomOrder()->first()->id; },
        'bus_type_id' => function() { return \App\Models\CbeInfoBusType::inRandomOrder()->first()->id; },
        'bus_route_id' => function() { return \App\Models\CbeInfoBusVia::inRandomOrder()->first()->id; },
        'bus_point_from' => function() { return \App\Models\CbeInfoLocationFrom::inRandomOrder()->first()->id; },
        'bus_point_to' => function() { return \App\Models\CbeInfoLocationTo::inRandomOrder()->first()->id; },
        // 'bus_time' => date('h:i A', time()),
        // 'bus_time' => Arr::random($timingArray),
        'bus_time' => date("H:i", strtotime(Arr::random($timingArray))),
        'created_by' => function() { return \App\Models\User::inRandomOrder()->first()->id; },
        'created_at' => now(),
    ];
});