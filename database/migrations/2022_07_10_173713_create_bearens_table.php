<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBearensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bearens', function (Blueprint $table) {
            $table->id();
            $table->string('month_name');
            $table->string('loss')->nullable();
            $table->string('earnings')->nullable();
            $table->string('pay')->nullable();
            $table->string('revenues')->nullable();
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
        Schema::dropIfExists('bearens');
    }
}
