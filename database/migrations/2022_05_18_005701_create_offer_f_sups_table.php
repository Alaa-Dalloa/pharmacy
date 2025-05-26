<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferFSupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_f_sups', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('company_factor');
            $table->string('production_date');
            $table->string('expiry_date');
            $table->string('product_photo');
            $table->string('quantity');
            $table->string('product_price_before_discount');
            $table->string('product_price_after_discount');
            $table->string('user_name');
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
        Schema::dropIfExists('offer_f_sups');
    }
}
