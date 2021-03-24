<?php

namespace Tests\Unit;

use App\Models\Answer;
use App\Models\Question;
use Illuminate\Foundation\Testing\RefreshDatabase;
// 使用 `php artisan make:test QuestionTest --unit` 命令生成后,
// 需要将 use PHPUnit\Framework\TestCase; 改成 `use Tests\TestCase;`
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_question_has_many_answers()
    {
        $question = Question::factory()->create();

        Answer::factory()->create(['question_id' => $question->id]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $question->answers());
    }
}
