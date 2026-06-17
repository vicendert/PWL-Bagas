<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sarana_fasilitas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lapangan_id')->nullable()->constrained('lapangan')->nullOnDelete();
            $table->string('kode_fasilitas', 20);
            $table->string('nama_unit');
            $table->text('alamat')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sarana_fasilitas');
    }
};
