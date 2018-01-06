<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBookmarksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookmarks', function (Blueprint $table) {
            $table->increments('id');
            $table->string("username");
            $table->string("title");
            $table->string("url");
            $table->string("permalink")->unique();
            $table->string("comment")->nullable();
            $table->boolean("is_private");
            $table->dateTime("htn_add_datetime");
            $table->integer("user_id")->unsigned();
            $table->timestamps();
            $table->index(['htn_add_datetime', 'id']);
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookmarks');
    }
}
