<?php

namespace Tests\Browser;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Laravel\Dusk\Browser;
use Tests\DuskTestCase;

class LoginTest extends DuskTestCase
{
    use DatabaseMigrations;

    /** @test */
    public function login_in_successfully()
    {
        create(User::class, ['email' => 'john@example.com']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'john@example.com')
                ->type('password', 'password')
                ->press('登录')
                ->assertPathIs('/questions');

            $browser->logout();
        });
    }

    /** @test */
    public function login_in_failed_with_wrong_password()
    {
        create(User::class, ['email' => 'john@example.com']);

        $this->browse(function (Browser $browser) {
            $browser->visit('/login')
                ->type('email', 'john@example.com')
                ->type('password', 'wrong-password')
                ->press('登录')
                ->assertPathIs('/login');
        });
    }
}
