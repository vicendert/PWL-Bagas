<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staf_qc', function (Blueprint $table) {
            $table->id();
            $table->string('nik', 50)->unique();
            $table->string('nama_staf');
            $table->string('gelar')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('jabatan');
            $table->foreignId('cabang_id')->nullable()->constrained('cabang')->nullOnDelete(); // Plotting Wilayah Cabang
            $table->foreignId('lapangan_id')->nullable()->constrained('lapangan')->nullOnDelete(); // Lokasi lapangan tugas
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staf_qc');
    }
};
