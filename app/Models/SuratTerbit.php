<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SuratTerbit extends Model
{
    protected $table = 'surat_terbit';

    protected $fillable = [
        'nomor_surat',
        'tanggal_terbit',
        'permintaan_surat_id',
        'jenis_surat_id',
    ];

    protected $casts = [
        'tanggal_terbit' => 'datetime',
    ];

    public function permintaanSurat()
    {
        return $this->belongsTo(PermintaanSurat::class, 'permintaan_surat_id');
    }

    public function jenisSurat()
    {
        return $this->belongsTo(JenisSurat::class, 'jenis_surat_id');
    }

    /**
     * Accessor untuk mendapatkan status dari PermintaanSurat
     */
    public function getStatusAttribute()
    {
        return $this->permintaanSurat?->status;
    }

    /**
     * Scope untuk filter berdasarkan status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->whereHas('permintaanSurat', function ($q) use ($status) {
            $q->where('status', $status);
        });
    }

    /**
     * Scope untuk eager load dengan status
     */
    public function scopeWithStatus($query)
    {
        return $query->with('permintaanSurat:id,status');
    }
}
