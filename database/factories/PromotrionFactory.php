<?php

use Faker\Generator as Faker;

$factory->define(App\Promotion::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'description' => $faker->paragraph(5, true),
    ];
});
