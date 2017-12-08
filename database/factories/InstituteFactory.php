<?php

use Faker\Generator as Faker;

$factory->define(App\Institute::class, function (Faker $faker) {
    return [
      'name' => $faker->company,
      'address' => $faker->address,
      'state' => $faker->state,
      'country' => $faker->country,
      'type' => 'School',
      'avatar' => $faker->imageUrl(150, 150, 'cats')
    ];
});
