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
        Schema::create('barang_fakturs', function (Blueprint $table) {
            $table->id();
            $table->string('no_faktur'); // No Faktur
            $table->string('supplier'); // Supplier
            $table->string('po_sp'); // PO/SP
            $table->string('faktur_supplier'); // Faktur Supplier
            $table->string('tgl_faktur_supplier'); // Tanggal Faktur Supplier
            $table->string('tgl_terima_barang'); // Tanggal Terima Barang
            $table->string('tgl_jatuh_tempo'); // Tanggal Jatuh Tempo
            $table->string('ppn'); // PPN
            $table->string('sub_total_barang'); // Sub Total Barang
            $table->string('total_ppn'); // Total PPN
            $table->string('total_materai'); // Total Materai
            $table->string('total_koreksi'); // Total Koreksi
            $table->string('total_harga'); // Total Harga
            $table->string('penerima_barang'); // Penerima Barang
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_fakturs');
    }
};
