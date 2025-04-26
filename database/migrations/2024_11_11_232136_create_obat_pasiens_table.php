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
        Schema::create('obat_pasiens', function (Blueprint $table) {
            $table->id();
            $table->string('no_rm');
            $table->string('no_rawat');
            $table->string('nama_pasien');
            $table->string('tgl');
            $table->string('jam');
            $table->string('penjab');
            $table->string('header')->nullable()->change();
            $table->string('kode_obat')->nullable()->change();
            $table->string('nama_obat')->nullable()->change();
            $table->string('dosis')->nullable()->change();
            $table->string('dosis_satuan')->nullable()->change();
            $table->string('instruksi')->nullable()->change();
            $table->string('signa_s')->nullable()->change();
            $table->string('signa_x')->nullable()->change();
            $table->string('signa_besaran')->nullable()->change();
            $table->string('signa_keterangan')->nullable()->change();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obat_pasiens');
    }
};
