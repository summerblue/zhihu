<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function name_is_required()
    {
        $this->withExceptionHandling()->post('/register', [
            'name' => '',
            'email' => 'john@example.com',
            'password' => '42352345652745',
            'password_confirmation' => '42352345652745',
        ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function name_can_not_contains_other_character()
    {
        $this->withExceptionHandling()->post('/register', [
            'name' => '***',
            'email' => 'john@example.com',
            'password' => '42352345652745',
            'password_confirmation' => '42352345652745',
        ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function name_just_contains_character_and_number_and_dash_and_underscore_is_permitted()
    {
        $this->assertEquals(0, User::all()->count());

        $this->post('/register', [
            'name' => 'nofirst1-_',
            'email' => 'john@example.com',
            'password' => '42352345652745',
            'password_confirmation' => '42352345652745',
        ]);

        $this->assertEquals(1, User::all()->count());
    }

    /** @test */
    public function name_is_at_least_two_characters()
    {
        $this->withExceptionHandling()->post('/register', [
            'name' => 'a',
            'email' => 'john@example.com',
            'password' => '42352345652745',
            'password_confirmation' => '42352345652745',
        ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function name_is_no_more_than_twenty_five_characters()
    {
        $this->withExceptionHandling()->post('/register', [
            'name' => 'abcdefghijklmnopqrstuvwxyz',
            'email' => 'john@example.com',
            'password' => '42352345652745',
            'password_confirmation' => '42352345652745',
        ])->assertSessionHasErrors('name');
    }

    /** @test */
    public function name_must_be_unique()
    {
        create(User::class, ['name' => 'john']);

        $this->withExceptionHandling()->post('/register', [
            'name' => 'john',
            'email' => 'john@example.com',
            'password' => '42352345652745',
            'password_confirmation' => '42352345652745',
        ])->assertSessionHasErrors('name');
    }
}
