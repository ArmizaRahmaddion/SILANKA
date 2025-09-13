<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiSuratFinal extends Model
{
    use HasFactory;

    protected $table = 'final_surat';

    protected $fillable = [
        'surat_terbit_id',
        'jenis_surat_id',
        'permintaan_surat_id',
        'barcode',
        'barcode_data', // tambahan untuk menyimpan kode unik
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function suratTerbit()
    {
        return $this->belongsTo(SuratTerbit::class);
    }

    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function jenisSurat()
    {

        return $this->belongsTo(JenisSurat::class);
    }

    public function permintaanSurat()
    {

        return $this->belongsTo(PermintaanSurat::class);
    }
}
