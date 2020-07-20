<?php

namespace App\Translator;

class FakeSlugTranslator implements Translator
{
    public function translate($sentence)
    {
        return 'english-english';
    }
}
