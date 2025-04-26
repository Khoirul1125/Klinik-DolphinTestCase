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
        Schema::create('menu_manajemen', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama menu
            $table->string('route')->nullable(); // Route Laravel
            $table->string('icon')->nullable(); // (Opsional) Ikon menu
            $table->unsignedBigInteger('parent_id')->nullable(); // Untuk submenu
            $table->string('permission')->nullable(); // Permission yang dibutuhkan
            $table->boolean('is_visible')->default(true); // Apakah menu ini ditampilkan di sidebar
            $table->integer('order')->default(0); // Urutan menu
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus_manajemen');
    }
};
