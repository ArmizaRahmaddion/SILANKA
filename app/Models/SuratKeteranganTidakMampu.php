<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuratKeteranganTidakMampu extends Model
{
    use HasFactory;

    protected $table = 'surat_keterangan_tidak_mampu';

    protected $fillable = [
        'permintaan_surat_id',
        'keperluan',

        // Anak
        'anak_nama',
        'anak_nik',
        'anak_tempat_lahir',
        'anak_tanggal_lahir',
        'anak_jenis_kelamin',
        'anak_pekerjaan',
        'anak_status_perkawinan',
        'anak_alamat',

        // Orang Tua
        'ortu_nama',
        'ortu_nik',
        'ortu_tempat_lahir',
        'ortu_tanggal_lahir',
        'ortu_jenis_kelamin',
        'ortu_pekerjaan',
        'ortu_status_perkawinan',
        'ortu_alamat',
    ];

    /**
     * Relasi ke permintaan surat
     */
    public function permintaanSurat()
    {
        return $this->belongsTo(PermintaanSurat::class, 'permintaan_surat_id');
    }

    /**
     * Relasi ke anggota keluarga
     */
    public function tanggungJawab()
    {
        return $this->hasMany(SKTMKeluarga::class, 'surat_keterangan_tidak_mampu_id');
    }
}
