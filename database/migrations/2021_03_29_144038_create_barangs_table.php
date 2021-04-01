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
            $table->string('kode')->unique();
            $table->string('barcode')->nullable();
            $table->string('jenis')->nullable();
            $table->string('merk')->nullable();
            $table->string('type')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('kondisi')->nullable();
            $table->string('harga')->nullable();
            $table->integer('status')->nullable();
            $table->timestamps();
            $table->integer('created_by')->nullable();
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
