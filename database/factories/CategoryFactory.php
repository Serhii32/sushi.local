<?php

use Faker\Generator as Faker;

$factory->define(App\Category::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'titleSEO' => $faker->word,
        'descriptionSEO' => $faker->paragraph(1, true),
        'keywordsSEO' => $faker->words(5, true),
    ];
});