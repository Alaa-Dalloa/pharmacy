    <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleInvoicsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_invoics', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            //$table->string('product_name');
            $table->string('quantity');
            $table->string('price_total');
            $table->string('release_date')->nullable();
            $table->string('number')->default(0);
            $table->string('profitable');
            $table->integer('invoice_price_total')->nullable();
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
        Schema::dropIfExists('sale_invoics');
    }
}
