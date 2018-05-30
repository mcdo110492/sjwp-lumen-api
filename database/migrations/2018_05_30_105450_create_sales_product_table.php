<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salesProduct', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id');
            $table->double('price',11,2);
            $table->unsignedInteger('quantity');
            $table->unsignedInteger('sales_id');
            $table->timestamps();

            $table->index(['product_id','sales_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salesProduct');
    }
}
