<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'cat_id' => $faker->numberBetween(1,155),
        'name' => $faker->firstNameFemale,
        'min_price' =>  $faker->randomFloat('2',1,100),
    ];
});
