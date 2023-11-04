<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('lastname', 42);
            $table->string('firstname', 42);
            $table->string('age', 42);
            $table->string('role', 42);
            $table->string('level', 42)->nullable();
            $table->string('description', 42)->nullable();
            $table->string('email', 42);
            $table->string('password', 60);
            $table->string('number', 42)->nullable();
            $table->unsignedInteger('multimedia_id');
            $table->timestamps();
        });
    }

     /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
