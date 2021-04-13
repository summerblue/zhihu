<?php

namespace Database\Factories;

use App\Models\Question;
use App\Models\User;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create();
            },
            'question_id' => function () {
                return Question::factory()->create();
            }
        ];
    }
}
