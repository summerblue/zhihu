<?php

namespace Tests\Unit\Translator;

use App\Translator\BaiduSlugTranslator;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * @group online
 */
class BaiduSlugTranslatorTest extends TestCase
{
    /** @test */
    public function can_translate_chinese_to_english()
    {
        $translator = new BaiduSlugTranslator();

        $result = $translator->translate("英语英语");

        $this->assertEquals("english-english", Str::lower($result));
    }
}
