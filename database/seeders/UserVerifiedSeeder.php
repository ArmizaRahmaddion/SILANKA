<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserVerifiedSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userWarga = User::where('name', 'warga')->first();

        $data = [
            'user_id' => $userWarga->id,
            'nik' => '1234567890123456',
            'nama_lengkap' => 'Warga',
            'nomor_hp' => '08999999999',
            'jenis_kelamin' => 'L',
            'foto_ktp' => 'dummy.jpg',
            'status' => 'verified',
            'pesan_penolakan' => null,
        ];

        $userWarga->verifikasi()->create($data);
    }
}
