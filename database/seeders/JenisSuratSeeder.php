<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JenisSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $jenis_surat = [
            ['nama_surat' => 'Surat Keterangan Tidak Mampu', 'kode_surat' => 'SKTM', 'description' => 'Keterangan resmi kondisi ekonomi', 'icon' =>
            'bi-people'],
            ['nama_surat' => 'Surat Keterangan Domisili', 'kode_surat' => 'SKD', 'description' => 'Domisili tempat tinggal resmi.', 'icon' => 'bi-geo-alt'],
            ['nama_surat' => 'Surat Keterangan Meninggal Dunia', 'kode_surat' => 'SKKM', 'description' => 'Dokumen keterangan kematian.', 'icon' => 'bi-heartbreak'],
            ['nama_surat' => 'Surat Keterangan Usaha', 'kode_surat' => 'SKU', 'description' => 'Legalitas dan aktivitas usaha.', 'icon' => 'bi-briefcase'],
        ];

        foreach ($jenis_surat as $surat) {
            JenisSurat::create($surat);
        }
    }
}
