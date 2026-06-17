<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pemesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('lapangan_id')->constrained('lapangan')->cascadeOnDelete();
            $table->foreignId('slot_waktu_id')->nullable()->constrained('slot_waktu')->restrictOnDelete(); // Restricts slot deletion if bound to active booking!
            $table->date('tanggal');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->decimal('total_biaya', 12, 2);
            $table->enum('status', ['Aktif', 'Selesai', 'Batal'])->default('Aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pemesanan');
    }
};
