<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lapangan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hub_pusat_id')->constrained('hub_pusat')->cascadeOnDelete();
            $table->foreignId('kategori_lapangan_id')->constrained('kategori_lapangan')->cascadeOnDelete();
            $table->foreignId('cabang_id')->constrained('cabang')->cascadeOnDelete();
            $table->string('kode', 20)->unique();
            $table->string('nama_lapangan');
            $table->enum('akreditasi', ['A', 'B', 'C', 'Unggul'])->default('C');
            $table->string('nomor_sk')->nullable();
            $table->date('tanggal_sertifikasi')->nullable();
            $table->text('alamat')->nullable();
            $table->string('dokumen_legalitas')->nullable(); // PDF file path
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lapangan');
    }
};
