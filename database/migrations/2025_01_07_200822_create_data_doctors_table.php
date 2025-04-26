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
        Schema::create('data_doctors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->json('education')->nullable();         // Data pendidikan
            $table->json('certifications')->nullable();    // Data sertifikasi
            $table->string('bank_name')->nullable();       // Nama bank
            $table->string('bank_number')->nullable();     // Nomor rekening
            $table->string('bank_branch')->nullable();     // Cabang bank
            $table->timestamps();

            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_doctors');
    }
};
