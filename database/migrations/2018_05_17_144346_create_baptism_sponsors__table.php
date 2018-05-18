<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBaptismSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('baptismSponsors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('baptism_id');
            $table->string('sponsor',50);
            $table->timestamps();
            $table->index('baptism_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('baptismSponsors');
    }
}
