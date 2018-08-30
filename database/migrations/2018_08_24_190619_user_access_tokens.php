<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserAccessTokens extends Migration
{
    /**
     * Table name 
     * 
     * @var string
     */
    protected $table = 'user_access_tokens';
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->table, function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->index();
            $table->string('token')->unique();
            // $table->string('device')->nullable();
            $table->timestamps();
            $table->softDeletes()->index();
            // $table->string('ip')->nullable();
            // $table->string('device_details')->nullable();
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
