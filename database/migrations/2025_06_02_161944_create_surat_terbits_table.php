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
        Schema::create('surat_terbit', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat')->unique();
            $table->dateTime('tanggal_terbit');
            // Kolom status dihapus karena akan menggunakan status dari PermintaanSurat
            $table->foreignId('permintaan_surat_id')->constrained('permintaan_surat');
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_terbit');
    }
};
