<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRentalBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rental_barangs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('noreg')->unique();
            $table->uuid('barang_id');
            $table->uuid('barang_name');
            $table->string('barang_temp');
            $table->string('barang_harga');
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
        Schema::dropIfExists('rental_barangs');
    }
}
