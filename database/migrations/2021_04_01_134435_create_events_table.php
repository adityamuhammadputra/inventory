<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('noreg')->unique();
            $table->uuid('vendor_id')->nullable();
            $table->uuid('client_id')->nullable();
            $table->string('client_nama')->nullable();
            $table->string('name')->nullable();
            $table->date('date');
            $table->time('time');
            $table->string('location')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('diskon')->nullable();
            $table->string('total')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
