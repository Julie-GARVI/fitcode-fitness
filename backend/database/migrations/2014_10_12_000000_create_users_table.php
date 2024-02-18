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
            $table->string('gender', 50);
            $table->string('lastname', 50);
            $table->string('firstname', 50);
            $table->integer('age');
            $table->string('role', 50);
            $table->string('level', 50)->nullable();
            $table->text('description')->nullable();
            $table->string('email', 50);
            $table->string('password', 50);
            $table->integer('number')->nullable();
            $table->timestamps();
            $table->unsignedInteger('multimedia_id');
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
