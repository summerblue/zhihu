<?php

namespace App\Jobs;

use App\Models\Question;
use App\Translator\Translator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class TranslateSlug implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $question;

    public function __construct(Question $question)
    {
        $this->question = $question;
    }

    public function handle()
    {
        $slug = app(Translator::class)->translate($this->question->title);

        \DB::table('questions')->where('id', $this->question->id)->update(['slug' => $slug]);
    }
}
