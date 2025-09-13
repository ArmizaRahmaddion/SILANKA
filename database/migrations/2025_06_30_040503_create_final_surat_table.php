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
        Schema::create('final_surat', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('surat_terbit_id');
            $table->string('barcode')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->timestamps();

            $table->foreign('surat_terbit_id')->references('id')->on('surat_terbit')->onDelete('cascade');
            $table->foreignId('jenis_surat_id')->constrained('jenis_surat');
            $table->foreignId('permintaan_surat_id')->constrained('permintaan_surat');
            $table->foreign('verified_by')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('final_surat');
    }
};
