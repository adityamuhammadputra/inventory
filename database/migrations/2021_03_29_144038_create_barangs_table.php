<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barangs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kategori');
            $table->string('kategori_no');
            $table->string('kode')->unique();
            $table->string('barcode')->nullable();
            $table->string('jenis')->nullable();
            $table->string('merk')->nullable();
            $table->string('type')->nullable();
            $table->string('serial_number')->nullable();
            $table->integer('kondisi')->nullable();
            $table->string('harga')->nullable();
            $table->integer('status')->nullable();
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
        Schema::dropIfExists('barangs');
    }
}
