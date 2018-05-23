<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaptismTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baptism', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName',50);
            $table->string('middleName',50);
            $table->string('lastName',50);
            $table->string('nameExt',50)->nullable();
            $table->date('birthdate');
            $table->string('birthPlace',150)->nullable();
            $table->date('baptismDate');
            $table->unsignedInteger('book')->nullable();
            $table->unsignedInteger('page')->nullable();
            $table->unsignedInteger('entry')->nullable();
            $table->string('fatherName',150);
            $table->string('motherName',150);
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
        Schema::dropIfExists('baptism');
    }
}
