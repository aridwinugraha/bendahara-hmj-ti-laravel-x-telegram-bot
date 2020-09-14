<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLapKasPhTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lap_kas_ph', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang', 100);
            $table->double('jumlah_barang');
            $table->string('satuan_barang', 100);
            $table->double('harga_satuan_barang');
            $table->double('jumlah_harga_barang');
            $table->string('keterangan')->nullable();
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
        Schema::dropIfExists('lap_kas_ph');
    }
}
