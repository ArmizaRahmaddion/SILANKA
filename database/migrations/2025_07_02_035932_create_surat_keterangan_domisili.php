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
        Schema::create('surat_keterangan_domisili', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permintaan_surat_id')->nullable();
            $table->string('keperluan');
            $table->string('nama');
            $table->string('nik');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'perempuan']);
            $table->string('status_perkawinan');
            $table->string('agama');
            $table->string('pekerjaan');
            $table->string('alamat');
            $table->timestamps();

            $table->foreign('permintaan_surat_id')
                ->references('id')
                ->on('permintaan_surat')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keterangan_domisili');
    }
};
