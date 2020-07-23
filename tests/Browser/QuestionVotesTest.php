<?php

namespace Tests\Browser;

use App\Models\Category;
use App\Models\Question;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class QuestionVotesTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function vote_up_a_question()
    {
        $question = create(Question::class, ['published_at' => Carbon::now()]);
        $user = create(User::class, ['email' => 'john@example.com']);

        $this->browse(function (Browser $browser) use ($user, $question) {
            $browser->loginAs($user)
                ->visit($question->path())
                ->assertVue('votesCount', 0, '@question-affect-component');

            $browser->click('@question-up-vote1')
                ->pause(2000)
                ->assertVue('upVotesCount', 1, '@question-affect-component');

            $browser->click('@question-up-vote1')
                ->pause(2000)
                ->assertVue('upVotesCount', 0, '@question-affect-component');
        });
    }

    /** @test */
    public function vote_down_a_question()
    {
        $question = create(Question::class, ['published_at' => Carbon::now()]);
        $user = create(User::class, ['email' => 'john@example.com']);

        $this->browse(function (Browser $browser) use ($user, $question) {
            $browser->loginAs($user)
                ->visit($question->path())
                ->assertVue('downVotesCount', 0, '@question-affect-component');

            $browser->click('@question-down-vote1')
                ->pause(2000)
                ->assertVue('downVotesCount', 1, '@question-affect-component');

            $browser->click('@question-down-vote1')
                ->pause(2000)
                ->assertVue('downVotesCount', 0, '@question-affect-component');
        });
    }
}
