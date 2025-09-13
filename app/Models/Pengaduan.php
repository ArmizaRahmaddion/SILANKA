<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengaduan extends Model
{
    protected $table = 'pengaduan';

    protected $fillable = [
        'verifikasi_pengguna_id',
        'kategori_pengaduan_id',
        'tanggal',
        'pengaduan',
        'file',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriPengaduan::class, 'kategori_pengaduan_id');
    }

    public function verifikasi()
    {
        return $this->belongsTo(VerifikasiPengguna::class, 'verifikasi_pengguna_id');
    }
}
