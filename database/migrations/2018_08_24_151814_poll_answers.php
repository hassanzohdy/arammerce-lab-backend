<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PollAnswers extends Migration
{
    /**
     * Table name 
     * 
     * @var string
     */
    protected $table = 'poll_answers';
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
            $table->string('answer');
            $table->text('comment');
            $table->string('image');
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