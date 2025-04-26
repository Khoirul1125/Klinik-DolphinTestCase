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
        Schema::create('karyawans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_karyawan');
            $table->string('kode_karyawan')->nullable();
            $table->string('nik')->unique();
            $table->unsignedBigInteger('jabatan')->nullable();
            $table->enum('aktivasi', ['aktif', 'tidak aktif'])->default('aktif');
            $table->unsignedBigInteger('poli')->nullable();
            $table->date('tglawal')->nullable();
            $table->string('sip')->nullable();
            $table->string('expspri')->nullable();
            $table->string('str')->nullable();
            $table->string('expstr')->nullable();
            $table->string('pk')->nullable();
            $table->string('exppk')->nullable();
            $table->string('npwp')->nullable();
            $table->unsignedBigInteger('status_kerja')->nullable();
            $table->string('kode')->nullable();
            $table->text('Alamat')->nullable();
            $table->string('rt', 10)->nullable();
            $table->string('rw', 10)->nullable();
            $table->string('kode_pos', 10)->nullable();
            $table->enum('kewarganegaraan', ['wni', 'wna'])->nullable();
            $table->unsignedBigInteger('provinsi')->nullable();
            $table->unsignedBigInteger('kota_kabupaten')->nullable();
            $table->unsignedBigInteger('kecamatan')->nullable();
            $table->unsignedBigInteger('desa')->nullable();
            $table->enum('seks', ['laki-laki', 'perempuan'])->nullable();
            $table->string('tempat_lahir')->nullable();
            $table->date('tgllahir')->nullable();
            $table->string('agama')->nullable();
            $table->string('goldar', 3)->nullable();
            $table->enum('pernikahan', ['menikah', 'belum_nikah', 'cerai_hidup', 'cerai_mati'])->nullable();
            $table->string('telepon')->nullable();
            $table->unsignedBigInteger('suku')->nullable();
            $table->unsignedBigInteger('bangsa')->nullable();
            $table->unsignedBigInteger('bahasa')->nullable();
            $table->string('user_id');
            $table->string('pendidikan');
            $table->string('userinput');
            $table->string('userinputid');
            $table->string('posker');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karyawans');
    }
};
