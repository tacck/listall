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

$factory->define(App\Bookmark::class, function (Faker $faker) {
    return [
        'username' => $faker->userName,
        'title' => $faker->title,
        'url' => $faker->url,
        'permalink' => $faker->unique()->url,
        'comment' => str_random(255),
        'is_private' => 1,
        'is_read_for_later' => 0,
        'htn_add_datetime' => $faker->dateTime,
        'htn_add_date' => $faker->dateTime->format('Y-m-d'),
        'user_id' => $faker->randomDigitNotNull,
    ];
});
