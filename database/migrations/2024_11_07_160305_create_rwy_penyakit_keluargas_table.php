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
        Schema::create('rwy_penyakit_keluargas', function (Blueprint $table) {
            $table->id();
            $table->string('no_rawat');
            $table->string('keluarga');
            $table->string('penyakit_keluarga');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rwy_penyakit_keluargas');
    }
};
