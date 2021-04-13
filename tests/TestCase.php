<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use App\Models\User;
use Illuminate\Testing\TestResponse;
use App\Translator\FakeSlugTranslator;
use App\Translator\Translator;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutExceptionHandling();

        TestResponse::macro('data', function ($key) {
			// 通过  $this->original->getData() 可以获取到绑定给视图的原始数据
            return $this->original->getData()[$key];
        });

        $this->app->instance(Translator::class, new FakeSlugTranslator);
    }

    protected function signIn($user = null)
    {
        $user = $user ?: create(User::class);

        $this->actingAs($user);

        return $this;
    }
}
