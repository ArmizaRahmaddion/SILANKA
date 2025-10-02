<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPermintaanSurat extends Model
{
    use HasFactory;

    protected $table = 'status_permintaan_surats';

    protected $fillable = [
        'permintaan_surat_id',
        'user_id',
        'status',
        'keterangan',
        'tanggal_perubahan',
    ];

    protected $casts = [
        'tanggal_perubahan' => 'datetime',
    ];

    /**
     * Relasi ke PermintaanSurat
     */
    public function permintaanSurat()
    {
        return $this->belongsTo(PermintaanSurat::class, 'permintaan_surat_id');
    }

    /**
     * Relasi ke User yang melakukan perubahan status
     */
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Scope untuk mendapatkan status terbaru
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('tanggal_perubahan', 'desc');
    }

    /**
     * Get bagian berdasarkan role user
     */
    public function getBagianAttribute()
    {
        if (!$this->user) {
            return 'Unknown';
        }

        // Mapping role ke bagian
        $roleToBagian = [
            'staff-tu' => 'Tata Usaha',
            'seknag' => 'Sekretaris Nagari',
            'superadmin' => 'Wali Nagari',
        ];

        $userRole = $this->user->getRoleNames()->first();

        return $roleToBagian[$userRole] ?? 'Unknown';
    }

    /**
     * Scope untuk filter berdasarkan bagian
     */
    public function scopeByBagian($query, $bagian)
    {
        $bagianToRole = [
            'Tata Usaha' => 'staff-tu',
            'Sekretaris Nagari' => 'seknag',
            'Wali Nagari' => 'superadmin',
        ];

        if (isset($bagianToRole[$bagian])) {
            return $query->whereHas('user', function ($q) use ($bagianToRole, $bagian) {
                $q->whereHas('roles', function ($r) use ($bagianToRole, $bagian) {
                    $r->where('name', $bagianToRole[$bagian]);
                });
            });
        }

        return $query;
    }
}
