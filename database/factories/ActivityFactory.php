<?php

namespace Database\Factories;

use App\Models\Activity;
use App\Models\User;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
{
    protected $model = Activity::class;

    public function definition()
    {
        $question = Question::factory()->create();
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'subject_id' => $question->id,
            'subject_type' => get_class($question),
            'type' => 'published_question'
        ];
    }
}
