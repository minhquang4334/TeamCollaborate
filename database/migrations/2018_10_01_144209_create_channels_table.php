<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('channels', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default(0)->comment('0: public, 1:private, 2: protected');
            $table->integer('creator');
            $table->string('name');
            $table->string('purpose')->nullable();
            $table->string('description')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1: active, 0: inactive');
            $table->string('channel_id')->nullable();
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
        Schema::dropIfExists('channels');
    }
}
