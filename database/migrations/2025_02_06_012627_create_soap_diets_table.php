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
        Schema::create('soap_diets', function (Blueprint $table) {
            $table->id();
            $table->string('patient_id'); // No RM
            $table->string('rawatt_id'); // ID Rawat
            $table->string('jenis_diet');
            $table->json('jenis_makanan');
            $table->json('jenis_tidak_boleh_dimakan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('soap_diets');
    }
};
