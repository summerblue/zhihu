<?php

namespace Tests\Feature\Questions;

use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InviteUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function invited_users_are_notified_when_publish_a_question()
    {
        $john = create(User::class, ['name' => 'John']);
        $jane = create(User::class, ['name' => 'Jane']);

        $this->signIn($john);

        $question = create(Question::class, [
            'user_id' => $john->id,
            'content' => '@Jane please help me!',
            'published_at' => null
        ]);

        $this->assertCount(0, $jane->notifications);

        $this->postJson(route('published-questions.store', ['question' => $question]));

        // notification 关联关系被预加载过，所以要 refresh()
        $this->assertCount(1, $jane->refresh()->notifications);
    }

    /** @test */
    public function all_invited_users_are_notified()
    {
        $john = create(User::class, ['name' => 'John']);
        $jane = create(User::class, ['name' => 'Jane']);
        $foo = create(User::class, ['name' => 'Foo']);

        $this->signIn($john);

        $question = create(Question::class, [
            'user_id' => $john->id,
            'content' => '@Jane @Foo please help me!'
        ]);

        $this->assertCount(0, $jane->notifications);
        $this->assertCount(0, $foo->notifications);

        $this->postJson(route('published-questions.store', ['question' => $question]));

        $this->assertCount(1, $jane->refresh()->notifications);
        $this->assertCount(1, $foo->refresh()->notifications);
    }
}
