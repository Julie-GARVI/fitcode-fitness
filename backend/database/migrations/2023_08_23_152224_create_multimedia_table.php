<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMultimediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('multimedia', function (Blueprint $table) {
        $table->increments('id')->unsigned();
        $table->string('picture_path', 50)->nullable();
        $table->string('icon_path', 50)->nullable();
        $table->timestamps();
        $table->unsignedInteger('category_id')->nullable();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('multimedia');
    }
}
