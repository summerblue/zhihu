<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Activity;
use App\Models\Question;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Activity::class, function (Faker $faker) {
    $question = factory(Question::class)->create();

    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'subject_id' => $question->id,
        'subject_type' => get_class($question),
        'type' => 'published_question'
    ];
});
