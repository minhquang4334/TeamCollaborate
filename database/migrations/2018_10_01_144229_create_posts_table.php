<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content');
            $table->boolean('is_parent')->default(true)->comment('false: parent post, true: children post');
            $table->integer('channel_id');
            $table->integer('parent_id')->nullable();
            $table->integer('creator');
            $table->string('user_following_post')->nullable();
            $table->tinyInteger('type')->default(0)->comment('0: normal post, 1: pinned post');
            $table->tinyInteger('status')->default(1)->comment('0: block, 1: active');
            $table->softDeletes();
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
        Schema::dropIfExists('posts');
    }
}
