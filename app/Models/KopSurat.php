<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KopSurat extends Model
{
    use HasFactory;

    protected $table = 'kop_surat';

    protected $fillable = [
        'nama_instansi',
        'nama_instansi_2',
        'nama_instansi_3',
        'alamat',
        'telepon',
        'email',
        'website',
        'kode_pos',
        'logo',
        'header_content',
        'footer_content',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getFormattedHeaderAttribute()
    {
        $header = '';

        if ($this->logo) {
            $header .= '<div style="display: flex; align-items: center; margin-bottom: 20px;">';
            $header .= '<img src="'.asset('storage/'.$this->logo).'" style="width: 80px; height: 80px; margin-right: 20px;">';
            $header .= '<div style="text-align: center; flex: 1;">';
        } else {
            $header .= '<div style="text-align: center; margin-bottom: 20px;">';
        }

        $header .= '<h2 style="margin: 0; font-size: 16px; font-weight: bold; text-transform: uppercase;">'.$this->nama_instansi.'</h2>';

        if ($this->nama_instansi_2) {
            $header .= '<h3 style="margin: 5px 0; font-size: 14px; font-weight: bold; text-transform: uppercase;">'.$this->nama_instansi_2.'</h3>';
        }

        if ($this->nama_instansi_3) {
            $header .= '<h3 style="margin: 5px 0; font-size: 14px; font-weight: bold; text-transform: uppercase;">'.$this->nama_instansi_3.'</h3>';
        }

        // Informasi kontak
        $kontak = [];
        if ($this->alamat) {
            $kontak[] = 'Alamat : '.$this->alamat;
        }
        if ($this->email) {
            $kontak[] = 'Email : '.$this->email;
        }
        if ($this->kode_pos) {
            $kontak[] = 'Kode Pos : '.$this->kode_pos;
        }
        if ($this->telepon) {
            $kontak[] = 'Telp : '.$this->telepon;
        }
        if ($this->website) {
            $kontak[] = 'Website : '.$this->website;
        }

        if (! empty($kontak)) {
            $header .= '<p style="margin: 10px 0; font-size: 12px; line-height: 1.4;">'.implode(' ', $kontak).'</p>';
        }

        $header .= '</div>';
        if ($this->logo) {
            $header .= '</div>';
        }

        $header .= '<hr style="border: none; border-top: 3px solid #000; margin: 15px 0;">';

        return $header;
    }
}
