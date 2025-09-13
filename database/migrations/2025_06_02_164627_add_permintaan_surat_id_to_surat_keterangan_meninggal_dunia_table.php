<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPermintaanSuratIdToSuratKeteranganMeninggalDuniaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('surat_keterangan_meninggal_dunia', function (Blueprint $table) {
            // Tambahkan kolom permintaan_surat_id sebagai foreign key
            $table->unsignedBigInteger('permintaan_surat_id')->nullable()->after('id');

            // Tambahkan foreign key constraint
            $table->foreign('permintaan_surat_id')
                ->references('id')
                ->on('permintaan_surat')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surat_keterangan_meninggal_dunia', function (Blueprint $table) {
            // Drop foreign key constraint terlebih dahulu
            $table->dropForeign(['permintaan_surat_id']);

            // Kemudian drop kolom
            $table->dropColumn('permintaan_surat_id');
        });
    }
}
