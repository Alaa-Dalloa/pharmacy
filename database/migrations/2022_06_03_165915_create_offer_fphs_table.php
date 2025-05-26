<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOfferFphsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offer_fphs', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('discount');
            $table->string('discount_start_date');
            $table->string('discount_end_date');
            $table->string('quantity');
             $table->string('product_price_before_discount');
            $table->string('product_price_after_discount');
            $table->string('photo');
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
        Schema::dropIfExists('offer_fphs');
    }
}
