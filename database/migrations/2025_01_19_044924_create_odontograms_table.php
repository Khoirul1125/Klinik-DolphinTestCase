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
        Schema::create('odontograms', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id'); // No RM
            $table->string('rawatt_id'); // ID Rawat
            $table->integer('tooth_number'); // Nomor gigi
            $table->string('condition'); // Kondisi gigi (sehat, busuk, dll)
            $table->text('note')->nullable(); // Catatan tambahan
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odontograms');
    }
};
