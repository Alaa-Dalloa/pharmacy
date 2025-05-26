<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('pharmacies_price');
            $table->integer('customer_price');
            $table->integer('profitable');
            $table->string('count');
            $table->string('note');
            $table->string('photo');
            $table->string('description')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('alternative')->nullable();
            $table->string('company_factor');
            $table->boolean('prescrept');
            $table->string('category_name');
            $table->longText('Qrcode');
            $table->string('expire')->default(0);
            $table->string('timec_notify')->nullable();
            $table->string('messagec_notify')->nullable();
            $table->string('timee_notify')->nullable();
            $table->string('messagee_notify')->nullable();
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
        Schema::dropIfExists('products');
    }
}
