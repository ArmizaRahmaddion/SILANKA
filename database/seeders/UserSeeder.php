<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Super Admin',
            'email' => 'admin@gmail.com',
            'nik' => '1111111111111111',
            'nip' => '12917219',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('superadmin');

        $user = User::create([
            'name' => 'warga',
            'email' => 'warga@gmail.com',
            'nik' => '222222222222',
            'nip' => '12917220',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('masyarakat');

        $user = User::create([
            'name' => 'Sekeretaris Nagari',
            'email' => 'sekretaris@gmail.com',
            'nik' => '',
            'nip' => '12917222',
            'password' => Hash::make('password'),
        ]);

        $user->assignRole('seknag');
    }
}
