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
        Schema::create('sktm_keluarga', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_keterangan_tidak_mampu_id')->constrained('surat_keterangan_tidak_mampu')->onDelete('cascade');
            $table->string('nama');
            $table->integer('umur');
            $table->string('pekerjaan');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sktm_keluarga');
    }
};
