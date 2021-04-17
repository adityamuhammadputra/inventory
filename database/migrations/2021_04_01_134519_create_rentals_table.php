<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rentals', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('noreg')->unique();
            $table->uuid('client_id')->nullable();
            $table->string('nama')->nullable();
            $table->string('kontak')->nullable();
            $table->string('alamat')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('diskon')->nullable();
            $table->string('total')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('rentals');
    }
}
