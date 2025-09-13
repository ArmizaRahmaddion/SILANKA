<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('verifikasi_pengguna_id')->constrained('verifikasi_pengguna')->onDelete('cascade');
            $table->foreignId('kategori_pengaduan_id')->constrained('kategori_pengaduan')->onDelete('cascade');
            $table->date('tanggal');
            $table->text('pengaduan');
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
