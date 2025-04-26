<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('barang_faktur_details', function (Blueprint $table) {
            $table->id();
            $table->string('no_faktur'); // Menyimpan nomor faktur
            $table->string('tgl_terima');  // Menyimpan tanggal terima
            $table->string('kode_barang'); // Menyimpan nama barang
            $table->string('nama_barang'); // Menyimpan nama barang
            $table->string('qty'); // Menyimpan jumlah barang
            $table->string('harga'); // Menyimpan harga barang
            $table->string('exp')->nullable(); // Menyimpan tanggal kadaluarsa (nullable jika tidak ada)
            $table->string('diskon')->nullable(); // Menyimpan diskon barang
            $table->string('ppn')->nullable(); // Menyimpan diskon barang
            $table->string('kode_batch')->nullable(); // Menyimpan kode batch (nullable)
            $table->string('total'); // Menyimpan total harga barang
            $table->timestamps(); // Menyimpan created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_faktur_details');
    }
};
