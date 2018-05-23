<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productCategories', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('uuid');
            $table->string('name',150);
            $table->double('price',11,2)->default(0);
            $table->unsignedInteger('parent_id')->default(0);
            $table->timestamps();

            $table->index('parent_id'); // Parent ID is also the ID of productCategories
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('productCategories');
    }
}
