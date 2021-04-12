<?php

namespace  Database\Seeders;

use App\Models\Answer;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $now = Carbon::now();

        foreach (range(1, 100) as $index) {
            $answer = Answer::factory()->make([
                'user_id' => rand(1, 10),
                'question_id' => rand(1, 100),
            ]);

            $data[] = [
                'content' => $answer->content,
                'user_id' => $answer->user_id,
                'question_id' => $answer->question_id,
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString(),
            ];
        }

        Answer::insert($data);
    }
}
