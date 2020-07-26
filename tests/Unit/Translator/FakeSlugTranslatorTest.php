<?php

namespace Tests\Unit\Translator;

use App\Translator\FakeSlugTranslator;
use Illuminate\Support\Str;
use Tests\Testcase;

class FakeSlugTranslatorTest extends TestCase
{
    /** @test */
    public function can_translate_chinese_to_english()
    {
        $translator = new FakeSlugTranslator();

        $result = $translator->translate("英语 英语");

        $this->assertEquals("english-english", Str::lower($result));
    }
}
