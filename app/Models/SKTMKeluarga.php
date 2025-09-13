<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SKTMKeluarga extends Model
{
    use HasFactory;

    protected $table = 'sktm_keluarga';

    protected $fillable = [
        'surat_keterangan_tidak_mampu_id',
        'nama',
        'umur',
        'pekerjaan',
        'keterangan',
    ];

    /**
     * Relasi ke surat SKTM induk
     */
    public function sktm()
    {
        return $this->belongsTo(SuratKeteranganTidakMampu::class, 'surat_keterangan_tidak_mampu_id');
    }
}
