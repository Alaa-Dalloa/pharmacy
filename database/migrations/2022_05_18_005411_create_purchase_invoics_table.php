
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseInvoicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_invoics', function (Blueprint $table) {
            $table->id();
            $table->string('release_date')->nullable();
            $table->integer('invoice_price_total')->nullable();
            $table->string('product_name');
            $table->string('quantity');
            $table->string('repository');
            $table->string('number')->default(0);
            $table->string('price_total');
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
        Schema::dropIfExists('purchase_invoics');
    }
}
