<?php

// database/migrations/2024_XX_XX_create_surat_keterangan_meninggal_dunia_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratKeteranganMeninggalDuniaTable extends Migration
{
    public function up()
    {
        Schema::create('surat_keterangan_meninggal_dunia', function (Blueprint $table) {
            $table->id();
            $table->string('keperluan');
            $table->string('nama_almarhum');
            $table->string('nik_almarhum', 16);
            $table->string('tempat_lahir_almarhum');
            $table->date('tanggal_lahir_almarhum');
            $table->enum('jenis_kelamin_almarhum', ['Laki-laki', 'Perempuan']);
            $table->string('agama_almarhum');
            $table->text('alamat_almarhum');
            $table->date('tanggal_meninggal');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('surat_keterangan_meninggal_dunia');
    }
}
