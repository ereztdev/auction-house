<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Item;
use Faker\Generator as Faker;
dump('passing through Item fac');

    $testItemFresh = Item::create([
        'cat_id' => 20,
        'name' => 'testItem_1',
        'min_price' =>  5
    ]);
    $testItemFresh->save();

    $testItemOld = Item::create([
        'cat_id' => 20,
        'name' => 'testItem_2',
        'min_price' =>  10
    ]);
    $testItemOld->save();


$factory->define(Item::class, function (Faker $faker) {
    return [
        'cat_id' => $faker->numberBetween(1,155),
        'name' => $faker->firstNameFemale,
        'min_price' =>  $faker->randomFloat('2',1,100),
    ];
});
dump('finished through Item fac');
