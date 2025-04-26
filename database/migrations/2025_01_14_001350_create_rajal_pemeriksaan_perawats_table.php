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
        Schema::create('rajal_pemeriksaan_perawats', function (Blueprint $table) {
            $table->id();
            $table->string('no_rawat');
            $table->string('tgl_kunjungan');
            $table->string('time');
            $table->string('nama_pasien');
            $table->string('tgl_lahir');
            $table->string('umur_pasien');
            $table->json('subyektif');
            $table->string('tensi');
            $table->string('suhu');
            $table->string('nadi');
            $table->string('rr');
            $table->string('tinggi_badan');
            $table->string('berat_badan');
            $table->string('eye');
            $table->string('verbal');
            $table->string('motorik');
            $table->string('sadar');
            $table->string('spo2');
            $table->string('alergi');
            $table->string('lingkar_perut');
            $table->string('nilai_bmi');
            $table->string('status_bmi');
            $table->longText('headtotoe')->nullable();
            $table->string('stts_soap')->nullable();
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
        Schema::dropIfExists('rajal_pemeriksaan_perawats');
    }
};
