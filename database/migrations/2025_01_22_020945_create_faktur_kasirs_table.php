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
        Schema::create('faktur_kasirs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_faktur');
            $table->string('no_rm');
            $table->string('nama');
            $table->string('rawat');
            $table->string('jenis_px');
            $table->string('penjamin')->nullable();
            $table->string('sub_total');
            $table->string('potongan');
            $table->string('total_sementara');
            $table->string('administrasi');
            $table->string('materai');
            $table->string('tagihan');
            $table->string('kembalian');
            $table->string('bayar_1');
            $table->string('uang_bayar_1');
            $table->string('bank_bayar_1')->nullable();
            $table->string('ref_bayar_1')->nullable();
            $table->string('bayar_2')->nullable();
            $table->string('uang_bayar_2')->nullable();
            $table->string('bank_bayar_2')->nullable();
            $table->string('ref_bayar_2')->nullable();
            $table->string('bayar_3')->nullable();
            $table->string('uang_bayar_3')->nullable();
            $table->string('bank_bayar_3')->nullable();
            $table->string('ref_bayar_3')->nullable();
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
        Schema::dropIfExists('faktur_kasirs');
    }
};
