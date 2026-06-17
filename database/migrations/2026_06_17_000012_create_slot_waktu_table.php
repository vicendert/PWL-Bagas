<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('slot_waktu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lapangan_id')->constrained('lapangan')->cascadeOnDelete();
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
            $table->enum('tipe_slot', ['Reguler', 'Turnamen', 'Perawatan']);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('slot_waktu');
    }
};
