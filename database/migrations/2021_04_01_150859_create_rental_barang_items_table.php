<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalBarangItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_barang_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('rental_barang_id');
            $table->uuid('barang_id')->nullable();
            $table->uuid('barang_name')->nullable();
            $table->string('barang_temp')->nullable();
            $table->string('barang_harga')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rental_barang_items');
    }
}
