<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateSurat extends Model
{
    use HasFactory;

    protected $table = 'template_surat';

    protected $fillable = [
        'nama_template',
        'kategori',
        'judul_surat',
        'nomor_format',
        'isi_surat',
        'variables',
        'is_active',
        'keterangan',
    ];

    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean',
    ];

    // Scope untuk template aktif
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope berdasarkan kategori
    public function scopeByKategori($query, $kategori)
    {
        return $query->where('kategori', $kategori);
    }

    // Method untuk replace variables dalam template
    public function replaceVariables($data = [])
    {
        $isiSurat = $this->isi_surat;
        $judulSurat = $this->judul_surat;
        $nomorFormat = $this->nomor_format;

        // Replace variables dalam isi surat
        foreach ($data as $key => $value) {
            $isiSurat = str_replace('{'.$key.'}', $value, $isiSurat);
            $judulSurat = str_replace('{'.$key.'}', $value, $judulSurat);
            $nomorFormat = str_replace('{'.$key.'}', $value, $nomorFormat);
        }

        return [
            'judul_surat' => $judulSurat,
            'nomor_surat' => $nomorFormat,
            'isi_surat' => $isiSurat,
        ];
    }

    // Method untuk mendapatkan list variables yang digunakan
    public function getUsedVariables()
    {
        $content = $this->isi_surat.' '.$this->judul_surat.' '.$this->nomor_format;
        preg_match_all('/\{([^}]+)\}/', $content, $matches);

        return array_unique($matches[1]);
    }
}
