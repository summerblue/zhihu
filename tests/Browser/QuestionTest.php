<?php

namespace Tests\Browser;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class QuestionTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function create_question()
    {
        $user = create(User::class, ['email' => 'john@example.com', 'email_verified_at' => '2020-01-01 00:00:00']);
        $category = create(Category::class, ['name' => 'dusk test category']);

        $this->browse(function (Browser $browser) use ($user, $category) {
            $browser->loginAs($user)->visit('/questions/create');

            $browser->type('@question-title', 'dusk test title')
                ->select('@question-category', $category->id)
                ->type('@question-content', 'dusk test content')
                ->click('@question-submit')
                ->assertPathIs('/drafts')
                ->assertSee('dusk test title');
        });
    }
}
