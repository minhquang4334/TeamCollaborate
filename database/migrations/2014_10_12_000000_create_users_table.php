<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone_number', 20)->nullable();
            $table->string('address')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0: normal, 1: online, 2: sleep, 3:offline');
            $table->tinyInteger('gender')->nullable()->comment('0: male, 1: female, 2:others');
            $table->date('birthday')->nullable();
            $table->tinyInteger('japanese_level')->nullable();
            $table->text('japanese_certificate')->nullable();
            $table->string('facebook_url')->nullable();
            $table->string('university')->nullable();
            $table->boolean('is_teacher')->nullable();
            $table->boolean('is_bachelor')->default(1);
            $table->tinyInteger('grade')->default(1);
            $table->text('about_me')->nullable();
            $table->tinyInteger('active')->default(1)->comment('1: active, 0:blocked');
            $table->softDeletes();
            $table->rememberToken();
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
