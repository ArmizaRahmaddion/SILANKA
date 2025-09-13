<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\KategoriKoten;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriKontenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Berita'],
            ['nama_kategori' => 'Pengumuman'],
            ['nama_kategori' => 'Kegiatan'],
        ];
        foreach ($kategoris as $kategori) {
            $slug = Str::slug($kategori['nama_kategori']);
            $kategori['slug'] = $slug;

            KategoriKoten::create($kategori);
        }
    }
}
