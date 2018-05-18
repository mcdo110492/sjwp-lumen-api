<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConfirmationSponsorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('confirmationSponsors', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('confirmation_id');
            $table->string('sponsor');
            $table->timestamps();

            $table->index('confirmation_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('confirmationSponsors');
    }
}
