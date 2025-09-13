<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VerifikasiPengguna extends Model
{
    use HasFactory;

    protected $table = 'verifikasi_pengguna';

    protected $fillable = [
        'user_id',
        'nik',
        'nama_lengkap',
        'nomor_hp',
        'jenis_kelamin',
        'foto_ktp',
        'status',
        'pesan_penolakan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class);
    }
}
