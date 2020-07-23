<?php

namespace Tests\Unit;

use App\Models\Activity;
use App\Models\User;

use Tests\Testcase;

use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase

{
    use RefreshDatabase;

    /** @test */
    public function user_has_an_avatar_path()
    {
        $user = create(User::class, [
            'avatar_path' => 'http://example.com/avatar.png'
        ]);

        $this->assertEquals('http://example.com/avatar.png', $user->avatar_path);
    }

    /** @test */
    public function user_can_determine_avatar_path()
    {
        $user = create(User::class);
        $this->assertEquals(url('storage/avatars/default.png'), $user->avatar());
        $user->avatar_path = 'avatars/me.jpg';
        $this->assertEquals(url('storage/avatars/me.jpg'), $user->avatar());
    }

    /** @test */
    public function can_get_user_avatar_attribute()
    {
        $user = create(User::class, [
            'avatar_path' => 'avatars/example.png'
        ]);

        $this->assertEquals(url('storage/avatars/example.png'), $user->userAvatar);
    }

    /** @test */
    public function a_user_has_many_activities()
    {
        $user = create(User::class);

        create(Activity::class, ['user_id' => $user->id]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Relations\HasMany', $user->activities());
    }
}
