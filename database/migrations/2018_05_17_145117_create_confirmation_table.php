<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfirmationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirmation', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('profile_id');
            $table->date('confirmationDate')->nullable();
            $table->unsignedInteger('book')->nullable();
            $table->unsignedInteger('page')->nullable();
            $table->string('baptizedAt',50)->nullable();
            $table->date('baptismDate')->nullable();
            $table->string('remarks',150)->nullable();
            $table->unsignedInteger('minister_id');
            $table->timestamps();

            $table->index(['profile_id','minister_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('confirmation');
    }
}
