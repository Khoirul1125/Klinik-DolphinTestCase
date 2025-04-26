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
        Schema::create('faktur_apotek_prebayars', function (Blueprint $table) {
            $table->id();
            $table->string('kode_faktur');
            $table->string('no_rm');
            $table->string('nama');
            $table->string('rawat');
            $table->string('jenis_resep');
            $table->string('jenis_px');
            $table->string('tanggal');
            $table->string('jam');
            $table->string('nama_obat');
            $table->string('kode');
            $table->string('harga');
            $table->string('kuantitas');
            $table->string('total_harga');
            $table->string('diskon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faktur_apotek_prebayars');
    }
};
