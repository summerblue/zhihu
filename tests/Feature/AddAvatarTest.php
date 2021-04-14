<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AddAvatarTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function guests_can_not_add_avatars()
    {
        $this->withExceptionHandling();
        $this->post('/users/1/avatar')
            ->assertRedirect('/login');
    }

    /** @test */
    public function avatar_is_required()
    {
        $this->withExceptionHandling()->signIn();

        $this->post(route('user-avatars.store', ['user' => auth()->user()]), ['avatar' => null])
            ->assertStatus(302)
            ->assertSessionHasErrors('avatar');
    }

    /** @test */
    public function avatar_must_be_valid()
    {
        $this->withExceptionHandling()->signIn();

        $this->post(route('user-avatars.store', ['user' => auth()->user()]), ['avatar' => 'not-an-image'])
            ->assertStatus(302)
            ->assertSessionHasErrors('avatar');
    }

    /** @test */
    public function poster_image_must_be_at_least_200px_width()
    {
        $this->withExceptionHandling()->signIn();

        Storage::fake('public');

		// width 为 199 px，height 为 515 px，name 为 avatar.png 的图片文件
        $file = UploadedFile::fake()->image('avatar.png', 199, 516);

        $this->post(route('user-avatars.store', ['user' => auth()->user()]), ['avatar' => $file])
            ->assertStatus(302)
            ->assertSessionHasErrors('avatar');
    }

    /** @test */
    public function poster_image_must_be_at_least_200px_height()
    {
        $this->withExceptionHandling()->signIn();

        Storage::fake('public');

        $file = UploadedFile::fake()->image('avatar.png', 516, 199);

        $this->post(route('user-avatars.store', ['user' => auth()->user()]), ['avatar' => $file])
            ->assertStatus(302)
            ->assertSessionHasErrors('avatar');
    }

    /** @test */
    public function user_can_add_an_avatar()
    {
        $this->signIn();

		Storage::fake('public');

		$this->post(route('user-avatars.store', ['user' => auth()->user()]), [
			  'avatar' => $file = UploadedFile::fake()->image('avatar.jpg', 300, 300)
		]);

		// 断言用户的头像地址被更新，且与预期的一致
		$this->assertEquals('avatars/' . $file->hashName(), auth()->user()->avatar_path);
		//断言文件被成功存储
		Storage::disk('public')->assertExists('avatars/'. $file->hashName());
    }
}
