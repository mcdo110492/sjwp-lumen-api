<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMarriageSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marriageSponsors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('marriage_id');
            $table->string('sponsor',50);
            $table->timestamps();

            $table->index('marriage_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marriageSponsors');
    }
}
