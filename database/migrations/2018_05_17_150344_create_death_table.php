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
            $table->unsignedInteger('profile_id');
            $table->date('dateOfDeath');
            $table->string('burialPlace',150)->nullable();
            $table->date('burialDate');
            $table->unsignedInteger('book')->nullable();
            $table->unsignedInteger('page')->nullable();
            $table->unsignedInteger('entry')->nullable();
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
        Schema::dropIfExists('death');
    }
}
