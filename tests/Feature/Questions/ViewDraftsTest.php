<?php

namespace Tests\Feature;

use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ViewDraftsTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_may_not_view_drafts()
    {
         $this->withExceptionHandling();

        $this->get('/drafts', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function user_can_view_drafts()
    {
        $this->signIn($user = create(User::class));

        $question = factory(Question::class)->create([
            'published_at' => null,
            'user_id' => $user->id
        ]);

        $this->get('/drafts')
            ->assertStatus(200)
            ->assertSee($question->title);
    }

    /** @test */
    public function only_the_creator_can_view_it()
    {
        $this->withExceptionHandling();

        $john = create(User::class, ['name' => 'john']);
        $jane = create(User::class, ['name' => 'jane']);

        $questionWithJohn = create(Question::class, ['user_id' => $john->id]);
        $questionWithJane = create(Question::class, ['user_id' => $jane->id]);

        $this->signIn($john);

        $this->get('/drafts/')
            ->assertStatus(200)
            ->assertSee($questionWithJohn->title)
            ->assertDontSee($questionWithJane->title);
    }

    /** @test */
    public function can_not_see_a_published_question_in_drafts()
    {
        $this->signIn($user = create(User::class));

        $question = factory(Question::class)->create([
            'published_at' => Carbon::now(),
            'user_id' => $user->id
        ]);

        $this->get('/drafts')
            ->assertStatus(200)
            ->assertDontSee($question->title);
    }
}
