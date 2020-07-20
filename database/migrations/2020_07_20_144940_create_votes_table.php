<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVotesTable extends Migration
{
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id');
            $table->bigInteger('voted_id');
            $table->string('voted_type');
            $table->enum('type', ['vote_up', 'vote_down'])->default('vote_up');
            $table->timestamps();

            $table->unique(['user_id','voted_id','voted_type','type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
