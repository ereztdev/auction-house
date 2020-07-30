<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Bid;
use App\Item;
use App\User;
use Faker\Generator as Faker;

$factory->define(Bid::class, function (Faker $faker) {
    return [
        'cat_id' => $faker->unique()->randomDigit,
        'item_id' => Item::all()->random()->id,
        'user_id' => User::all()->random()->id,
        'bid_amount' => $faker->randomFloat(),
    ];
});
