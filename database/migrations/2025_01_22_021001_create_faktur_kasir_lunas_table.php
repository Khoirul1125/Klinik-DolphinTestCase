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
        Schema::create('faktur_kasir_lunas', function (Blueprint $table) {
            $table->id();
            $table->string('kode_faktur');
            $table->string('no_rm');
            $table->string('kode_obat')->nullable();
            $table->string('nama');
            $table->string('harga');
            $table->string('kuantitas')->nullable();
            $table->string('total_harga');
            $table->string('diskon')->nullable();
            $table->string('tanggal');
            $table->string('user_name');
            $table->string('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faktur_kasir_lunas');
    }
};
