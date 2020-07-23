<?php

namespace Tests\Unit;

use App\Events\PostComment;
use App\Models\User;
use App\Notifications\YouWereMentionedInComment;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;

trait AddCommentContractTest
{
    /** @test */
    public function an_notification_is_sent_when_a_comment_is_added()
    {
        Notification::fake();

        $john = create(User::class, [
            'name' => 'John'
        ]);

        $model = $this->getCommentModel();

        $model->comment("@John Thank you", $john);

        Notification::assertSentTo($john, YouWereMentionedInComment::class);
    }

    /** @test */
    public function an_event_is_dispatched_when_a_comment_is_added()
    {
        Event::fake();

        $user = create(User::class);

        $model = $this->getCommentModel();

        $model->comment('it is a content', $user);

        Event::assertDispatched(PostComment::class);
    }

    abstract protected function getCommentModel();
}
