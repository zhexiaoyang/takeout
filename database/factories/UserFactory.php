<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Models\User::class, function (Faker $faker) {
    static $password;
    $now = Carbon::now()->toDateTimeString();

    return [
        'name' => $faker->name,
        'phone' => $faker->unique()->phoneNumber,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('123123'),
        'remember_token' => str_random(10),
        'created_at' => $now,
        'updated_at' => $now,
    ];
});