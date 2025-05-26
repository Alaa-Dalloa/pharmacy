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
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->string('start_work_date')->nullable();
            $table->string('start_using_date')->nullable();
            $table->string('age')->nullable();
            $table->string('gender')->nullable();
            $table->string('the_job')->nullable();
            $table->string('working_days')->nullable();
            $table->string('phone')->nullable();
            $table->string('salary')->nullable();
            $table->string('adress')->nullable();
            $table->string('user_type')->nullable();
            $table->boolean('user_type_bolean')->default(0);
            $table->text('fcm_token')->nullable();
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
