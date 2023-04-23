<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
           // $table->increments('id');
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->unsignedBigInteger('events_id');
            $table->boolean('attendance')->default(false);
            $table->timestamps();

            $table->foreign('users_id')->references('id')->on('users');
            $table->foreign('events_id')->references('id')->on('events');

            //$table->primary(['users_id', 'events_id']);
            $table->unique(['users_id', 'events_id']);


        });
    }

    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
};
