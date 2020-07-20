<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Category;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Question::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create();
        },
        'category_id' => function () {
            return factory(Category::class)->create();
        },
        'title' => $faker->sentence,
        'content' => $faker->text
    ];
});

$factory->state(Question::class,'published',function ($faker) {
    return [
        'published_at' => Carbon::parse('-1 week')
    ];
});

$factory->state(Question::class,'unpublished',function ($faker) {
    return [
        'published_at' => null
    ];
});
