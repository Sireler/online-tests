<?php

use App\Survey;
use Faker\Generator as Faker;

$factory->define(Survey::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        }
    ];
});
