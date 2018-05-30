<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpenseCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expenseCategories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',150);
            $table->unsignedInteger('parent_id');
            $table->timestamps();

            $table->index('parent_id'); // parent_id is also the id of expenseCategories
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('expenseCategories');
    }
}
