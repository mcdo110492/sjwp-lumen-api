<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeathTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('death', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName',50);
            $table->string('middleName',50);
            $table->string('lastName',50);
            $table->string('nameExt',50)->nullable();
            $table->string('residence',150);
            $table->string('nativeOf',150)->nullable();
            $table->date('deathDate');
            $table->string('burialPlace',150);
            $table->date('burialDate');
            $table->unsignedInteger('book');
            $table->unsignedInteger('page');
            $table->unsignedInteger('entry');
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
        Schema::dropIfExists('death');
    }
}
