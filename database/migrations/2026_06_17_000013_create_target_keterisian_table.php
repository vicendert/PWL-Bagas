<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('target_keterisian', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lapangan_id')->constrained('lapangan')->cascadeOnDelete();
            $table->year('tahun');
            $table->unsignedTinyInteger('bulan'); // 1-12
            $table->unsignedInteger('target_jam'); // target rental hours per month
            $table->unsignedInteger('realisasi_jam')->default(0); // actual hours booked
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('target_keterisian');
    }
};
