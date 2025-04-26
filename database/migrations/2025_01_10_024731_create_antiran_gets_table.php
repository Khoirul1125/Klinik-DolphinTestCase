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
        Schema::create('antiran_gets', function (Blueprint $table) {
            $table->id();
            $table->string('nomorkartu')->nullable();
            $table->string('nik');
            $table->string('nohp')->nullable();
            $table->string('no_reg')->nullable();
            $table->string('kodepoli')->nullable();
            $table->string('namapoli')->nullable();
            $table->string('norm')->nullable();
            $table->date('tanggalperiksa')->nullable();
            $table->string('keluhan')->nullable();
            $table->string('kodedokter')->nullable();
            $table->string('namadokter')->nullable();
            $table->string('jampraktek')->nullable();
            $table->string('nomorantrean')->nullable();
            $table->integer('angkaantrean')->nullable();
            $table->text('keterangan')->nullable();
            $table->integer('sta_antian')->nullable();
            $table->string('infoantrean')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antiran_gets');
    }
};
