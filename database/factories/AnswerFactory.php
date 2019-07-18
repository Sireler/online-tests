<?php

use App\SurveyAnswer as Answer;
use Faker\Generator as Faker;

$factory->define(Answer::class, function (Faker $faker) {
    return [
        'text' => $faker->name,
        'survey_question_id' => function () {
            return factory(App\SurveyQuestion::class)->create()->id;
        }
    ];
});
