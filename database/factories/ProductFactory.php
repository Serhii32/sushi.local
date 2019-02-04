<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'price' => $faker->randomFloat(2, 0, 1000000),
        'weight' => $faker->word,
        'titleSEO' => $faker->word,
        'descriptionSEO' => $faker->paragraph(1, true),
        'keywordsSEO' => $faker->words(5, true),
    ];
});