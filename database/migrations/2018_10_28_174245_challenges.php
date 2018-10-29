<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Challenges extends Migration
{
    /**
     * Table name 
     * 
     * @var string
     */
    protected $table = 'challenges';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->fullText();
            $table->string('status')->index();
            $table->string('starts_at')->index();
            $table->string('ends_at')->index();
            $table->text('description');
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
