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
        Schema::create('faktur_apoteks', function (Blueprint $table) {
            $table->id();
            $table->string('no_reg')->nullable();
            $table->string('no_rm');
            $table->string('nama');
            $table->string('alamat')->nullable();
            $table->string('jenis_resep');
            $table->string('kode_faktur');
            $table->string('rawat');
            $table->string('nama_poli');
            $table->string('dokter')->nullable();
            $table->string('jenis_px');
            $table->string('penjamin')->nullable();
            $table->string('total_embis')->nullable();
            $table->string('sub_total');
            $table->string('total');
            $table->string('stts_bayar');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faktur_apoteks');
    }
};
