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
        Schema::create('pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm')->unique();
            $table->string('nik');
            $table->string('kode_ihs');
            $table->string('nama');
            $table->string('tempat_lahir')->nullable();
            $table->string('tanggal_lahir')->nullable();
            $table->string('no_bpjs')->nullable();
            $table->string('tgl_akhir')->nullable();
            $table->string('kelas_bpjs')->nullable();
            $table->string('jenis_bpjs')->nullable();
            $table->string('provide')->nullable();
            $table->string('kodeprovide')->nullable();
            $table->string('hubungan_keluarga')->nullable();
            $table->string('Alamat')->nullable();
            $table->integer('rt')->nullable();
            $table->integer('rw')->nullable();
            $table->integer('kode_pos')->nullable();
            $table->string('kewarganegaraan')->nullable();
            $table->string('seks')->nullable();
            $table->string('agama')->nullable();
            $table->string('pendidikan')->nullable();
            $table->foreignId('goldar_id')->constrained()->onDelete('cascade'); // Foreign key to `users` table
            $table->string('pernikahan')->nullable();
            $table->string('pekerjaan')->nullable();
            $table->string('telepon')->nullable();
            $table->string('provinsi_kode')->nullable();
            $table->string('kabupaten_kode')->nullable();
            $table->string('kecamatan_kode')->nullable();
            $table->string('desa_kode')->nullable();
            $table->integer('suku')->nullable();
            $table->integer('bahasa')->nullable();
            $table->integer('bangsa')->nullable();
            $table->foreign('provinsi_kode')->references('kode')->on('provinsi')->onDelete('cascade');
            $table->foreign('kabupaten_kode')->references('kode')->on('kabupaten')->onDelete('cascade');
            $table->foreign('kecamatan_kode')->references('kode')->on('kecamatan')->onDelete('cascade');
            $table->foreign('desa_kode')->references('kode')->on('desa')->onDelete('cascade');
            $table->integer('statusdata')->nullable();
            $table->string('userinput')->nullable();
            $table->integer('userinputid')->nullable();
            $table->integer('user_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pasiens');
    }
};
