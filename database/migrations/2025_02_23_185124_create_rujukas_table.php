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
        Schema::create('rujukas', function (Blueprint $table) {
            $table->id();
            $table->string('no_rujuk')->unique();
            $table->string('no_reg')->nullable();
            $table->string('no_rawat');
            $table->string('kd_dokter');
            $table->string('kd_poli');
            $table->string('kd_pj');
            $table->string('kode_sub_spesialis')->nullable(); // Bisa NULL jika RJRS_KUHUS
            $table->string('kode_rumahsakit');
            $table->string('nama_rumahsakit');
            $table->string('alamat_rumahsakit');
            $table->string('no_telp_rumahsakit');
            $table->date('tgl_rujuk');
            $table->date('tanggal_berlaku')->nullable();
            $table->string('kd_sarana')->nullable(); // Bisa null jika tidak diisi
            $table->string('kd_khusus')->nullable(); // Bisa null jika RJRS
            $table->text('catatan')->nullable(); // Bisa null jika RJRS
            $table->string('kdTacc')->default("0"); // Default ke 0 jika RJRS_KUHUS
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rujukas');
    }
};
