<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratKeteranganUsaha extends Model
{
    protected $table = 'surat_keterangan_usaha';

    protected $fillable = [
        'permintaan_surat_id',
        'keperluan',
        'nama',
        'nik',
        'jenis_kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'status_perkawinan',
        'agama',
        'pekerjaan',
        'alamat',
        'jenis_usaha',
        'luas_usaha',
    ];

    protected $cast = [
        'tanggal_lahir' => 'date',
    ];

    public function permintaanSurat()
    {
        return $this->belongsTo(PermintaanSurat::class, 'permintaan_surat_id');
    }
}
