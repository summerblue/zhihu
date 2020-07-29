<?php

namespace Tests\Unit;

use App\Models\Question;
use App\Models\Subscription;
use App\Models\User;
use Helpers\PublishedQuestionFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_subscription_belongs_to_a_user()
    {
        $subscription = create(Subscription::class);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsTo', $subscription->user());
    }

    /** @test */
    public function can_know_it_if_subscribed_to()
    {
        $this->signIn();

        $question = PublishedQuestionFactory::createPublished();

        $this->post('/questions/' . $question->id . '/subscriptions');

        $this->assertTrue($question->refresh()->isSubscribedTo(Auth::user()));
    }

    /** @test */
    public function can_know_subscriptions_count()
    {
        $question = PublishedQuestionFactory::createPublished();

        $this->signIn();
        $this->post('/questions/' . $question->id . '/subscriptions');
        $this->assertEquals(1, $question->refresh()->subscriptionsCount);

        // 切换成另一个用户登录
        $this->signIn(create(User::class));
        $this->post('/questions/' . $question->id . '/subscriptions');

        $this->assertEquals(2, $question->refresh()->subscriptionsCount);
    }
}
