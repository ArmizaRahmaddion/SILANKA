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

    /**
     * Relasi ke StatusPermintaanSurat untuk tracking riwayat
     */
    public function statusPermintaan()
    {
        return $this->hasMany(StatusPermintaanSurat::class, 'permintaan_surat_id');
    }

    /**
     * Get status terakhir dari riwayat status
     */
    public function latestStatusPermintaan()
    {
        return $this->hasOne(StatusPermintaanSurat::class, 'permintaan_surat_id')
            ->latest('tanggal_perubahan');
    }

    /**
     * Get bagian saat ini berdasarkan status terakhir
     */
    public function getBagianSaatIniAttribute()
    {
        $latestStatus = $this->latestStatusPermintaan;

        if (!$latestStatus || !$latestStatus->user) {
            return 'Tata Usaha'; // Default
        }

        return $latestStatus->bagian;
    }

    /**
     * Get progress status untuk riwayat
     */
    public function getProgressStatusAttribute()
    {
        $bagianList = ['Tata Usaha', 'Sekretaris Nagari', 'Wali Nagari'];
        $bagianSaatIni = $this->bagian_saat_ini;

        return [
            'current_bagian' => $bagianSaatIni,
            'current_index' => array_search($bagianSaatIni, $bagianList),
            'total_steps' => count($bagianList),
            'progress_percentage' => (array_search($bagianSaatIni, $bagianList) + 1) / count($bagianList) * 100
        ];
    }
}
