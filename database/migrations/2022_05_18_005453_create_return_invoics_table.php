<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReturnInvoicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('return_invoics', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('price_total');
            $table->string('count');
            $table->string('number')->default(0);
            $table->string('sell_date')->nullable();
            $table->integer('invoic_price_total')->nullable();
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
        Schema::dropIfExists('return_invoics');
    }
}
