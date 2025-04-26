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
        Schema::create('set_satusehats', function (Blueprint $table) {
            $table->id();
            $table->string('org_id');
            $table->string('client_id');
            $table->string('client_secret');
            $table->string('SCREET_KEY'); // Corrected from 'SCREET' to match your input
            $table->string('SATUSEHAT_BASE_URL');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('set_satusehats');
    }
};
