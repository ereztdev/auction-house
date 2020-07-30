<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'cat_id' => $faker->unique()->randomDigit,
        'name' => $faker->streetName,
        'min_price' => $faker->randomFloat(),
    ];
});
