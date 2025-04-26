<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('schedules_dokter', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('doctor_id'); // Asosiasi ke dokter
            $table->string('start');
            $table->string('end');
            $table->integer('quota');
            $table->integer('total_quota');
            $table->integer('hari');
            $table->string('userinput');
            $table->string('userinputid');
            $table->timestamps();

            // Foreign key ke tabel `doctors`
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');
        });
    }

    public function down() : void
    {
        Schema::dropIfExists('schedules');
    }
};
