<?php

use Faker\Generator as Faker;
use App\ClassRoom;

$factory->define(App\ClassRoom::class, function (Faker $faker) {
    return [
      'class_name' => $faker->company,
      'avatar' => $faker->imageUrl(150, 150, 'cats'),
      'user_id' => 1
    ];
});
