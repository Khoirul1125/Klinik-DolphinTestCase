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
        Schema::create('dabars', function (Blueprint $table) {
            $table->id();
            $table->string('kode')->unique();
            $table->string('formularium');
            $table->string('nama');
            $table->string('kode_dpho');
            $table->string('nama_dpho');
            $table->string('kode_kfa');
            $table->string('harga_dasar');
            $table->string('satuan_id');
            $table->string('satuan_sedang');
            $table->string('kode_satuan_sedang');
            $table->string('satuan_besar');
            $table->string('kode_satuan_besar');
            $table->string('penyimpanan');
            $table->string('barcode');
            $table->string('industri');
            $table->string('jenbar_id');
            $table->string('nama_generik');
            $table->string('bentuk_kesediaan');
            $table->string('dosis');
            $table->string('kode_dosis');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dabars');
    }
};
