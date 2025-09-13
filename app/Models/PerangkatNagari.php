<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerangkatNagari extends Model
{
    protected $table = 'perangkat_nagari';

    protected $fillable = [
        'nama', 'nip', 'jabatan', 'kontak', 'image', 'facebook', 'instagram',
    ];
}
