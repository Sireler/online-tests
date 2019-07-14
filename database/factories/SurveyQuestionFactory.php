<?php

use App\SurveyQuestion as Question;
use App\Survey;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'type' => 'radio',
        'survey_id' => function () {
            return factory(App\Survey::class)->create()->id;
        }
    ];
});
