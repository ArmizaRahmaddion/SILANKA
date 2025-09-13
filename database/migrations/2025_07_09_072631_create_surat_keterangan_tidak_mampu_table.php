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
        Schema::create('surat_keterangan_tidak_mampu', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('permintaan_surat_id')->nullable();
            $table->string('keperluan');
            $table->foreign('permintaan_surat_id')
                ->references('id')
                ->on('permintaan_surat')
                ->onDelete('cascade');
            // Anak (Ybs)
            $table->string('anak_nama');
            $table->string('anak_nik', 16);
            $table->string('anak_tempat_lahir');
            $table->date('anak_tanggal_lahir');
            $table->enum('anak_jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('anak_pekerjaan');
            $table->string('anak_status_perkawinan');
            $table->string('anak_alamat');

            // Orang Tua
            $table->string('ortu_nama');
            $table->string('ortu_nik', 16);
            $table->string('ortu_tempat_lahir');
            $table->date('ortu_tanggal_lahir');
            $table->enum('ortu_jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('ortu_pekerjaan');
            $table->string('ortu_status_perkawinan');
            $table->string('ortu_alamat');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_keterangan_tidak_mampu');
    }
};
