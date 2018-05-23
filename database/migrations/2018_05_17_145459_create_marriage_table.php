<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarriageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marriage', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('wife_id');
            $table->unsignedInteger('husband_id');
            $table->date('dateMarried');
            $table->unsignedInteger('book');
            $table->unsignedInteger('page');
            $table->unsignedInteger('entry');
            $table->unsignedInteger('minister_id');
            $table->timestamps();

            $table->index(['wife_id','husband_id','minister_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marriage');
    }
}
