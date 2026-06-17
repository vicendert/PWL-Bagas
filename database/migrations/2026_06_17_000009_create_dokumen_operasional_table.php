<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dokumen_operasional', function (Blueprint $table) {
            $table->id();
            $table->string('nama_dokumen');
            $table->year('tahun');
            $table->enum('kategori', ['Kebijakan', 'Manual', 'Legalitas', 'Sistem Informasi']);
            $table->enum('unit_pengunggah', ['Cabang', 'Fakultas', 'Pusat']);
            $table->string('jabatan_pengunggah');
            $table->string('file_path'); // PDF up to 7MB
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dokumen_operasional');
    }
};
