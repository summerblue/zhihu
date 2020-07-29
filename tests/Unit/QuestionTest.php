<?php

namespace Tests\Unit;

use App\Events\PostComment;
use App\Jobs\TranslateSlug;
use App\Models\Answer;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Question;
use App\Models\Subscription;
use App\Models\User;
use App\Notifications\QuestionWasUpdated;
use App\Notifications\YouWereMentionedInComment;
use Carbon\Carbon;
use Helpers\PublishedQuestionFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class QuestionTest extends TestCase
{
    use RefreshDatabase;

    use AddCommentContractTest;
    use ActivitiesContractTest;

    public function getActivityModel()
    {
        return create(Question::class);
    }

    public function getActivityType()
    {
        return 'published_question';
    }

    public function getCommentModel()
    {
        return create(Question::class);
    }

    /** @test */
    public function a_question_has_many_answers()
    {
        $question = create(Question::class);

        create(Answer::class, ['question_id' => $question->id]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $question->answers());
    }

    /** @test */
    public function questions_with_published_at_date_are_published()
    {
        $publishedQuestion1 = PublishedQuestionFactory::createPublished();
        $publishedQuestion2 = PublishedQuestionFactory::createPublished();
        $unpublishedQuestion = PublishedQuestionFactory::createUnpublished();

        $publishedQuestions = Question::published()->get();

        $this->assertTrue($publishedQuestions->contains($publishedQuestion1));
        $this->assertTrue($publishedQuestions->contains($publishedQuestion2));
        $this->assertFalse($publishedQuestions->contains($unpublishedQuestion));
    }

    /** @test */
    public function can_mark_an_answer_as_best()
    {
        $question = create(Question::class, ['best_answer_id' => null]);

        $answer = create(Answer::class, ['question_id' => $question->id]);

        $question->markAsBestAnswer($answer);

        $this->assertEquals($question->best_answer_id, $answer->id);
    }

    /** @test */
    public function a_question_belongs_to_a_creator()
    {
        $question = create(Question::class);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\BelongsTo', $question->creator());
        $this->assertInstanceOf('App\Models\User', $question->creator);
    }

    /** @test */
    public function can_publish_a_question()
    {
        $question = create(Question::class, ['published_at' => null]);

        $this->assertCount(0, Question::published()->get());

        $question->publish();

        $this->assertCount(1, Question::published()->get());
    }

    /** @test */
    public function it_can_detect_all_invited_users()
    {
        $question = create(Question::class, [
            'content' => '@Jane @Luke please help me!'
        ]);

        $this->assertEquals(['Jane','Luke'], $question->invitedUsers());
    }

    /** @test */
    public function questions_without_published_at_date_are_drafts()
    {
        $user = create(User::class);

        $draft1 = create(Question::class, ['user_id' => $user->id, 'published_at' => null]);
        $draft2 = create(Question::class, ['user_id' => $user->id, 'published_at' => null]);
        $publishedQuestion = create(Question::class, ['user_id' => $user->id, 'published_at' => Carbon::now()]);

        $drafts = Question::drafts($user->id)->get();

        $this->assertTrue($drafts->contains($draft1));
        $this->assertTrue($drafts->contains($draft2));
        $this->assertFalse($drafts->contains($publishedQuestion));
    }

    /** @test */
    public function question_has_answers_count()
    {
        $question = create(Question::class);
        create(Answer::class, ['question_id' => $question->id]);

        $this->assertEquals(1, $question->refresh()->answers_count);
    }

    /** @test */
    public function a_question_has_many_subscriptions()
    {
        $question = create(Question::class);

        create(Subscription::class, ['question_id' => $question->id], 2);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $question->subscriptions());
    }

    /** @test */
    public function question_can_be_subscribed_to()
    {
        $user = create(User::class);
        $question = create(Question::class, ['user_id' => $user->id]);

        $question->subscribe($user->id);

        $this->assertEquals(
            1,
            $question->subscriptions()->where('user_id', $user->id)->count()
        );
    }

    /** @test */
    public function question_can_be_unsubscribed_from()
    {
        $user = create(User::class);
        $userId = $user->id;

        $question = create(Question::class, ['user_id' => $userId]);

        $question->subscribe($userId);

        $question->unsubscribe($userId);

        $this->assertEquals(
            0,
            $question->subscriptions()->where('user_id', $userId)->count()
        );
    }

    /** @test */
    public function question_can_add_answer()
    {
        $question = create(Question::class);

        $question->addAnswer([
            'content' => create(Answer::class)->content,
            'user_id' => create(User::class)->id
        ]);

        $this->assertEquals(1, $question->refresh()->answers()->count());
    }

    /** @test */
    public function notify_all_subscribers_when_an_answer_is_added()
    {
        Notification::fake();

        $user = create(User::class);

        $question = create(Question::class);

        $question->subscribe($user->id)
            ->addAnswer([
                'content' => 'Foobar',
                'user_id' => 999 // 伪造一个与当前登录用户不同的 id
            ]);

        Notification::assertSentTo($user, QuestionWasUpdated::class);
    }

    /** @test */
    public function a_translate_slug_job_is_pushed_when_create_question()
    {
        Queue::fake();

        create(Question::class, ['title' => '英语 英语']);

        Queue::assertPushed(TranslateSlug::class);
    }

    /** @test */
    public function question_has_a_path()
    {
        $category = create(Category::class);

        $question = create(Question::class, [
            'slug' => 'english-english',
            'category_id' => $category->id
        ]);

        $this->assertEquals("/questions/{$question->category->slug}/{$question->id}/english-english", $question->path());
    }

    /** @test */
    public function a_question_belongs_to_a_category()
    {
        $question = create(Question::class);

        $this->assertInstanceOf(Category::class, $question->category);
    }

    /** @test */
    public function a_question_has_many_comments()
    {
        $question = factory(Question::class)->create();

        create(Comment::class, [
            'commented_id' => $question->id,
            'commented_type' => $question->getMorphClass(),
            'content' => 'it is a comment'
        ]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\MorphMany', $question->comments());
    }

    /** @test */
    public function can_comment_a_question()
    {
        $question = create(Question::class);

        $question->comment('it is content', create(User::class));

        $this->assertEquals(1, $question->refresh()->comments()->count());
    }

    /** @test */
    public function can_get_comments_count_attribute()
    {
        $question = create(Question::class);

        $question->comment('it is content', create(User::class));

        $this->assertEquals(1, $question->refresh()->commentsCount);
    }

    /** @test */
    public function can_get_comment_endpoint_attribute()
    {
        $question = create(Question::class);

        $question->comment('it is content', create(User::class));

        $this->assertEquals("/questions/{$question->id}/comments", $question->refresh()->commentEndpoint);
    }
}
