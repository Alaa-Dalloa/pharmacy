<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('count');
            $table->string('product_photo');
            $table->string('price_total');
            $table->string('profitable');
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('user_name')->nullable();
            $table->string('order_price_total')->nullable();
            $table->string('message_notify')->nullable();
            $table->string('time_notify')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
