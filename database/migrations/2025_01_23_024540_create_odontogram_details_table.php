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
        Schema::create('odontogram_details', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id');
            $table->string('rawatt_id');
            $table->string('Decayed')->nullable();
            $table->string('Missing')->nullable();
            $table->string('Filled')->nullable();
            $table->integer('Foto')->default(0);
            $table->integer('Rontgen')->default(0);
            $table->string('Oclusi')->nullable();
            $table->string('Palatinus')->nullable();
            $table->string('Mandibularis')->nullable();
            $table->string('Platum')->nullable();
            $table->string('Diastema')->nullable();
            $table->string('Anomali')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('odontogram_details');
    }
};
