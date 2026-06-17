<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('standar_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('parent_id')->nullable()->constrained('standar_fasilitas')->nullOnDelete();
            $table->string('nama_fasilitas');
            $table->text('deskripsi'); // Rich Text Editor (HTML)
            $table->enum('jenis_indikator', ['kuantitatif', 'kualitatif']);
            $table->decimal('bobot_kelayakan', 5, 2); // percentage
            $table->integer('urutan')->default(0); // For ordering buttons
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('standar_fasilitas');
    }
};
