<?php

namespace Tests\Unit\Http\Middleware;

use App\Http\Middleware\MustVerifyEmail;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Tests\Testcase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MustVerifyEmailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function unverified_user_must_verify_email_before_do_something_not_allowed()
    {
        $this->signIn(create(User::class, [
            'email_verified_at' => null
        ]));

        $middleware = new MustVerifyEmail();

        // handle() 方法接收一个 Request 实例和一个 闭包
        // 如果闭包函数被执行，说明中间件未生效，测试失败
        $response = $middleware->handle(new Request, function ($request) {
            $this->fail("Next middleware was called.");
        });

        $this->assertInstanceOf(RedirectResponse::class, $response);
        $this->assertEquals(url('/email/verify'), $response->getTargetUrl());
    }

    /** @test */
    public function verified_user_can_continue()
    {
        $this->be(create(User::class, [
            'email_verified_at' => Carbon::now()
        ]));

        $request = new Request();

        // 当尝试以调用函数的方式调用一个对象时，__invoke() 方法会被自动调用
        // 非常适合用来测试闭包函数是否被调用
        $next = new class {
            public $called = false;

            public function __invoke($request)
            {
                $this->called = true;

                return $request;
            }
        };

        $middleware = new MustVerifyEmail();

        $response = $middleware->handle($request, $next);

        $this->assertTrue($next->called);
        $this->assertSame($request, $response);
    }
}
