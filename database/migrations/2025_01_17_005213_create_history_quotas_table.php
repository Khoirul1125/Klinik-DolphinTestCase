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
        Schema::create('history_quotas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('schedule_id');
            $table->enum('action', ['increase', 'decrease']);
            $table->integer('amount');
            $table->integer('remaining_quota');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_quotas');
    }
};
