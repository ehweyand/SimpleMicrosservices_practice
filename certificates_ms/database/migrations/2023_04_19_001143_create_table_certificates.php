<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->date('emission_date');
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('events_id');
            $table->string('auth_code');
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('events_id')->references('id')->on('events');
        });
    }

    public function down()
    {
        Schema::dropIfExists('certificates');
    }
};
