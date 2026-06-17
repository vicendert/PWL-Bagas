<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tarif_skema', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cabang_id')->constrained('cabang')->cascadeOnDelete();
            $table->year('tahun');
            $table->decimal('nilai_tarif', 12, 2);
            $table->string('deskripsi_skema_jam'); // e.g. "Pagi (08:00 - 15:00)" atau "Malam (15:00 - 22:00)"
            $table->string('periode'); // e.g. "Musim Reguler", "Turnamen"
            $table->string('lokasi_lapangan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tarif_skema');
    }
};
