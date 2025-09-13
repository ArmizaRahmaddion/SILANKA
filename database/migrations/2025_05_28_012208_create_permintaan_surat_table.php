<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePermintaanSuratTable extends Migration
{
    public function up()
    {
        Schema::create('permintaan_surat', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal_permintaan');
            $table->enum('status', ['Diterima', 'Diproses', 'Selesai', 'Ditolak', 'Batal'])->default('Diproses');
            $table->unsignedBigInteger('jenis_surat_id');
            $table->foreign('jenis_surat_id')->references('id')->on('jenis_surat')->onDelete('cascade');
            $table->unsignedBigInteger('verifikasi_pengguna_id');
            $table->foreign('verifikasi_pengguna_id')->references('id')->on('verifikasi_pengguna')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('permintaan_surat');
    }
}
