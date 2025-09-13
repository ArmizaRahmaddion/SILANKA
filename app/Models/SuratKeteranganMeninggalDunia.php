<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeteranganMeninggalDunia extends Model
{
    protected $table = 'surat_keterangan_meninggal_dunia';

    protected $fillable = [
        'permintaan_surat_id', // Tambahkan field ini
        'keperluan',
        'nama_almarhum',
        'nik_almarhum',
        'tempat_lahir_almarhum',
        'tanggal_lahir_almarhum',
        'jenis_kelamin_almarhum',
        'agama_almarhum',
        'alamat_almarhum',
        'tanggal_meninggal',
    ];

    protected $casts = [
        'tanggal_lahir_almarhum' => 'date',
        'tanggal_meninggal' => 'date',
    ];

    /**
     * Relasi ke PermintaanSurat
     */
    public function permintaanSurat()
    {
        return $this->belongsTo(PermintaanSurat::class, 'permintaan_surat_id');
    }
}
