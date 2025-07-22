<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            ['name' => 'Super Admin', 'password' => Hash::make('password')]
        );
        $user->assignRole('super_admin');

        $user = User::firstOrCreate(
            ['email' => 'akademik@akademik.com'],
            ['name' => 'Akademik Account', 'password' => Hash::make('password')]
        );
        $user->assignRole('akademik');

        $user = User::firstOrCreate(
            ['email' => 'ilhamshv@gmail.com'],
            ['name' => 'Ilham', 'password' => Hash::make('password')]
        );
        $user->assignRole('peserta');
    }
}
