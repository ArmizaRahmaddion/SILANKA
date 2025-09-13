<?php

namespace Database\Seeders;

use App\Models\KategoriPengaduan;
use Illuminate\Database\Seeder;

class KategoriPengaduanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['nama_kategori' => 'Pelayanan Publik'],
            ['nama_kategori' => 'Infrastruktur'],
            ['nama_kategori' => 'Lingkungan Hidup'],
            ['nama_kategori' => 'Kesehatan'],
            ['nama_kategori' => 'Pendidikan'],
            ['nama_kategori' => 'Keamanan'],
            ['nama_kategori' => 'Lainnya'],
        ];

        foreach ($data as $item) {
            KategoriPengaduan::create($item);
        }
    }
}
