<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PermintaanSurat extends Model
{
    protected $table = 'permintaan_surat';

    protected $fillable = [
        'tanggal_permintaan',
        'status',
        'jenis_surat_id',
        'verifikasi_pengguna_id',
    ];

    protected $casts = [
        'tanggal_permintaan' => 'date',
    ];

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    public function verifikasiPengguna()
    {
        return $this->belongsTo(VerifikasiPengguna::class, 'verifikasi_pengguna_id');
    }

    /**
     * Relasi ke Surat
     */
    public function suratKeteranganMeninggalDunia()
    {
        return $this->hasOne(SuratKeteranganMeninggalDunia::class, 'permintaan_surat_id');
    }

    public function suratKeteranganDomisili()
    {
        return $this->hasOne(SuratKeteranganDomisili::class, 'permintaan_surat_id');
    }

    public function suratKeteranganUsaha()
    {
        return $this->hasOne(SuratKeteranganUsaha::class, 'permintaan_surat_id');
    }

    public function suratKeteranganTidakMampu()
    {
        return $this->hasOne(SuratKeteranganTidakMampu::class, 'permintaan_surat_id');
    }

    public function suratTerbit()
    {
        return $this->hasMany(SuratTerbit::class, 'permintaan_surat_id');
    }
}
