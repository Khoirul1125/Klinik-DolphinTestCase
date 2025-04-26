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
        Schema::create('rajal_pemeriksaans', function (Blueprint $table) {
            $table->id(); // BIGINT UNSIGNED by default
            $table->string('no_reg'); // VARCHAR(50) untuk no_rawat
            $table->string('no_rm'); // VARCHAR(50) untuk no_rawat
            $table->string('no_rawat'); // VARCHAR(50) untuk no_rawat
            $table->string('tgl_kunjungan');
            $table->string('time');
            $table->string('nama_pasien');
            $table->string('tgl_lahir');
            $table->string('umur_pasien');
            $table->json('subyektif'); // TEXT
            $table->string('tensi');
            $table->string('suhu');
            $table->string('nadi');
            $table->string('rr');
            $table->string('tinggi_badan');
            $table->string('berat_badan');
            $table->string('spo2');
            $table->string('eye');
            $table->string('verbal');
            $table->string('motorik');
            $table->string('sadar');
            $table->string('alergi');
            $table->string('lingkar_perut');
            $table->string('nilai_bmi');
            $table->string('status_bmi');
            $table->longText('htt_pemeriksaan')->nullable();
            $table->string('cerita_dokter');
            $table->text('assessmen'); // TEXT
            $table->text('plan'); // TEXT
            $table->text('instruksi'); // TEXT
            $table->text('evaluasi'); // TEXT
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rajal_pemeriksaans');
    }
};
