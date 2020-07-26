<?php

namespace Tests\Feature\Comments;

use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Notifications\Notification;
use Tests\TestCase;

class MentionUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function mentioned_users_are_notified_when_comment_a_question()
    {
        $john = create(User::class, ['name' => 'John']);
        $jane = create(User::class, ['name' => 'Jane']);
        $foo = create(User::class, ['name' => 'Foo']);

        $this->signIn($john);

        $question = create(Question::class, ['published_at' => Carbon::now()]);

        $this->assertCount(0, $jane->notifications);
        $this->assertCount(0, $foo->notifications);

        $this->postJson(route('question-comments.store', ['question' => $question]), [
            'content' => '@Jane @Foo please help me!'
        ]);

        $this->assertCount(1, $jane->refresh()->notifications);
        $this->assertCount(1, $foo->refresh()->notifications);
    }
}
