<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang_logs', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('barang_id')->nullable();
            $table->uuid('event_id')->nullable();
            $table->uuid('rental_id')->nullable();
            // $table->string('kode')->nullable();
            $table->date('start')->nullable();
            $table->date('end')->nullable();
            $table->dateTime('deleted')->nullable();

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
        Schema::dropIfExists('barang_logs');
    }
}
