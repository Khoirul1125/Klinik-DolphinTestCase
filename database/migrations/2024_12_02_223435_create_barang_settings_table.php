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
        Schema::create('barang_settings', function (Blueprint $table) {
            $table->id();
            $table->string('hj_1');
            $table->string('hj_2');
            $table->string('hj_3');
            $table->string('hj_4');
            $table->string('hj_5');
            $table->string('embalase');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang_settings');
    }
};
