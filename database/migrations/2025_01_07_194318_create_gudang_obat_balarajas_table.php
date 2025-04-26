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
        Schema::create('gudang_obat_balarajas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_klinik');
            $table->string('nama_klinik');
            $table->string('kode_obat');
            $table->string('nama_obat');
            $table->string('harga_dasar');
            $table->string('harga_jual');
            $table->integer('jumlah');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gudang_obat_balarajas');
    }
};
