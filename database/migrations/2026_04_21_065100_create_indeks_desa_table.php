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
        Schema::create('indeks_desa', function (Blueprint $table) {
            $table->string('id')->primary(); // Format: tahun-id_desa

            $table->string('id_desa');
            $table->string('id_kecamatan');

            $table->integer('dimensi_layanan_dasar');
            $table->integer('dimensi_sosial');
            $table->integer('dimensi_ekonomi');
            $table->integer('dimensi_lingkungan');
            $table->integer('dimensi_aksesibilitas');
            $table->integer('dimensi_tata_kelola_pemerintah');

            $table->decimal('skor', 10, 2);
            $table->string('status_indeks');

            $table->year('tahun');

            $table->timestamps();

            // FK ke desa
            $table->foreign('id_desa')
                ->references('id_desa')
                ->on('desa')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            // FK ke kecamatan
            $table->foreign('id_kecamatan')
                ->references('id_kecamatan')
                ->on('kecamatan')
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            // Hindari duplikasi
            $table->unique(['id_desa', 'tahun']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indeks_desa');
    }
};
