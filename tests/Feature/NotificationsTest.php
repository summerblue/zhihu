<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->signIn();
    }

    /** @test */
    public function a_notification_is_prepared_when_a_subscribed_question_receives_a_new_answer_by_other_people()
    {
        $question = create(Question::class, [
            'user_id' => auth()->id()
        ]);

        $question->subscribe(auth()->id());

        $this->assertCount(0, auth()->user()->notifications);

        $question->addAnswer([
            'user_id' => auth()->id(),
            'content' => 'Some reply here'
        ]);

        $this->assertCount(0, auth()->user()->fresh()->notifications);

        $question->addAnswer([
            'user_id' => create(User::class)->id,
            'content' => 'Some reply here'
        ]);

        $this->assertCount(1, auth()->user()->fresh()->notifications);
    }
}
