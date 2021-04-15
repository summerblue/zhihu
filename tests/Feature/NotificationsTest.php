<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Notifications\DatabaseNotification;

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

    /** @test */
    public function a_user_can_fetch_their_unread_notifications()
    {
        $question = create(Question::class, [
            'user_id' => auth()->id()
        ]);

        $question->subscribe(auth()->id());

        $question->addAnswer([
            'user_id' => create(User::class)->id,
            'content' => 'Some reply here'
        ]);

        $response =  $this->get(route('user-notifications.index', ['user' => auth()->user()]));
		$result = $response->data('notifications')->toArray();

		$this->assertCount(1, $result['data']);
		$this->assertEquals(1, $result['total']);
    }

    /** @test */
    public function guests_can_not_see_unread_notifications_page()
    {
        $this->withExceptionHandling();
        auth()->logout();

        $this->get(route('user-notifications.index'))
            ->assertRedirect('/login');
    }

    /** @test */
    public function clear_all_unread_notifications_after_see_unread_notifications_page()
    {
        $question = create(Question::class, [
            'user_id' => auth()->id()
        ]);

        $question->subscribe(auth()->id());

        $question->addAnswer([
            'user_id' => create(User::class)->id,
            'content' => 'Some reply here'
        ]);
        $this->assertCount(1, auth()->user()->fresh()->unreadNotifications);

        $this->get(route('user-notifications.index', ['user' => auth()->user()]));

        $this->assertCount(0, auth()->user()->fresh()->unreadNotifications);
    }
}
