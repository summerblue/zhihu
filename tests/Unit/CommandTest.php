<?php

namespace Tests\Unit;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Tests\Testcase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_calculate_active_user_by_artisan_command()
    {
        $john = create(User::class, ['name' => 'john']);
        $jane = create(User::class, ['name' => 'jane']);

        // john 创建了 1 个 Question，得 4 分
        $question = create(Question::class, ['user_id' => $john->id]);
        // jane 创建了 1 个 Answer，得 1 分
        create(Answer::class, ['user_id' => $jane->id, 'question_id' => $question->id]);

        // 创建 10 个用户，但都不是活跃用户
        create(User::class, [], 10);

        $this->artisan('zhihu:calculate-active-user')
            ->expectsOutput('开始计算...')
            ->expectsOutput('成功生成！')
            ->assertExitCode(0);

        $activeUsers = Cache::get('zhihu_active_users');

        $this->assertEquals(2, $activeUsers->count());
        // john 在前
        $this->assertTrue($john->is($activeUsers[0]));
        // jone 在后
        $this->assertTrue($jane->is($activeUsers[1]));
    }
}
