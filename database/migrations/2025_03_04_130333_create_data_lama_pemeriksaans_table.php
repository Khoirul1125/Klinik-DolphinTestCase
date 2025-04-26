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
        Schema::create('data_lama_pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->string('tanggal_pelayanan')->nullable();
            $table->string('no_rm')->nullable();
            $table->string('nama_pasien')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('nama_dokter')->nullable();
            $table->string('keadaan_umum')->nullable();
            $table->string('kesadaran_pasien')->nullable();
            $table->string('tekanan_darah')->nullable();
            $table->string('nadi')->nullable();
            $table->string('suhu')->nullable();
            $table->string('pernafasan')->nullable();
            $table->string('tinggi_badan')->nullable();
            $table->string('berat_badan')->nullable();
            $table->string('nasabah')->nullable();
            $table->string('resep')->nullable();
            $table->string('diagnosa')->nullable();
            $table->string('tindakan')->nullable();
            $table->string('laboratorium')->nullable();
            $table->string('radiologi')->nullable();
            $table->string('status_pcare')->nullable();
            $table->string('no_surat')->nullable();
            $table->string('keterangan')->nullable();
            $table->string('yth')->nullable();
            $table->string('rujuk_bagian')->nullable();
            $table->string('jam_masuk')->nullable();
            $table->string('jam_keluar')->nullable();
            $table->string('no_kunjungan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_lama_pemeriksaans');
    }
};
