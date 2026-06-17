<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rekap_kelayakan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lapangan_id')->constrained('lapangan')->cascadeOnDelete();
            $table->unsignedInteger('target_keterisian_jam');
            $table->decimal('nilai_kondisi_mandiri', 5, 2);
            $table->decimal('nilai_tim_qc', 5, 2);
            $table->enum('grade', ['A', 'B', 'C', 'D', 'E'])->default('C');
            $table->unsignedTinyInteger('bintang')->default(3); // 1-5 stars visualization
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rekap_kelayakan');
    }
};
