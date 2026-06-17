<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kategori_lapangan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori'); // Badminton, Futsal, Basket, Voli, dll
            $table->string('icon')->nullable();
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kategori_lapangan');
    }
};
