<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TaskUserRequirements extends Migration
{
    /**
     * Table name 
     * 
     * @var string
     */
    protected $table = 'task_user_requirements';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('task_id')->index();
            $table->integer('user_id')->index();
            $table->integer('Task_requirement_id')->index();
            $table->string('status');
            $table->text('content');
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
