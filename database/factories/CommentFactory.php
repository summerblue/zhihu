<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\User;
use App\Models\Question;
use Illuminate\Database\Eloquent\Factories\Factory;

class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition()
    {
        $question = Question::factory()->create();

        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'content' => $this->faker->text,
            'commented_id' => $question->id,
            'commented_type' => get_class($question)
        ];
    }
}
