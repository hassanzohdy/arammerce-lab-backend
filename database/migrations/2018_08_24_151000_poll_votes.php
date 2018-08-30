<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PollVotes extends Migration
{
    /**
     * Table name 
     * 
     * @var string
     */
    protected $table = 'poll_votes';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('poll_id')->index();
            $table->integer('poll_answer_id')->index();
            $table->string('poll_answer');
            $table->string('poll_answer_image');
            $table->text('comment');
            $table->loggers();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists($this->table);
    }
}
