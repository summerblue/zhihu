<?php

use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class QuestionSeeder extends Seeder
{
    public function run()
    {
        $data = [];
        $now = Carbon::now();

        foreach (range(1, 100) as $index) {
            $question = factory(Question::class)->make([
                'user_id' => rand(1, 10),
                'category_id' => rand(1, 4),
            ]);

            $data[] = [
                'title' => $question->title,
                'content' => $question->content,
                'user_id' => $question->user_id,
                'category_id' => $question->category_id,
                'created_at' => $now->toDateTimeString(),
                'updated_at' => $now->toDateTimeString(),
                'published_at' => $now->toDateTimeString(),
            ];
        }

        Question::insert($data);
    }
}
