<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedInteger('user_id');
            $table->string('title');
            $table->text('content');
            $table->dateTime('published_at')->nullable();
            $table->unsignedInteger('best_answer_id')->nullable();
            $table->timestamps();
            $table->unsignedInteger('category_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('questions');
    }
}
