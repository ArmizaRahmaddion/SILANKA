<?php

namespace Database\Seeders;

use App\Models\KategoriKoten;
use Illuminate\Database\Seeder;

class KategoriKotenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Berita Umum', 'slug' => 'berita-umum'],
            ['nama_kategori' => 'Pengumuman', 'slug' => 'pengumuman'],
            ['nama_kategori' => 'Kegiatan Nagari', 'slug' => 'kegiatan-nagari'],
            ['nama_kategori' => 'Pelayanan Publik', 'slug' => 'pelayanan-publik'],
            ['nama_kategori' => 'Artikel', 'slug' => 'artikel'],
            ['nama_kategori' => 'Tutorial', 'slug' => 'tutorial'],
        ];

        foreach ($kategoris as $kategori) {
            KategoriKoten::create($kategori);
        }
    }
}
