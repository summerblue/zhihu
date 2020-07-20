<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comment;
use App\Models\Question;
use App\Models\User;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    $question = factory(Question::class)->create();

    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'content' => $faker->text,
        'commented_id' => $question->id,
        'commented_type' => get_class($question)
    ];
});
