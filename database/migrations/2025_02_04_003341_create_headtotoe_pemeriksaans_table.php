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
        Schema::create('headtotoe_pemeriksaans', function (Blueprint $table) {
            $table->id();
            $table->string('kode_pemeriksaan');
            $table->string('nama_pemeriksaan');
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
        Schema::dropIfExists('headtotoe_pemeriksaans');
    }
};
