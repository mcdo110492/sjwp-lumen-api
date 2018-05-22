<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarriageWifeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marriageWife', function (Blueprint $table) {
            $table->increments('id');
            $table->string('firstName',50);
            $table->string('motherName',50);
            $table->string('lastName',50);
            $table->date('birthdate');
            $table->string('religion',50)->nullable();
            $table->string('residence',50)->nullable();
            $table->string('fatherName',50);
            $table->string('motherName',50);
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
        Schema::dropIfExists('marriageWife');
    }
}
