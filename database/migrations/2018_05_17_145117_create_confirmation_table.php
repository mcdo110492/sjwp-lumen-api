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
            $table->string('firstName',50);
            $table->string('middleName',50);
            $table->string('lastName',50);
            $table->string('nameExt',50)->nullable();
            $table->date('confirmationDate');
            $table->date('baptismDate');
            $table->string('baptizedAt',150)->nullable();
            $table->unsignedInteger('book')->nullable();
            $table->unsignedInteger('page')->nullable();
            $table->unsignedInteger('minister_id');
            $table->timestamps();

            $table->index('minister_id');
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
