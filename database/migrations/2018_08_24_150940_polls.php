<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Polls extends Migration
{
    /**
     * Table name 
     * 
     * @var string
     */
    protected $table = 'polls';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('status')->index();
            $table->text('description');
            $table->string('type'); // single|multi
            $table->boolean('allow_more_answers'); // determine if the poll can be expanded for more answers by users
            $table->boolean('requires_comment'); // forces the user to make a comment on his selection or not
            $table->timestamp('ends_at')->index();
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
