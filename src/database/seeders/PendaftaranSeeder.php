<?php

namespace Database\Seeders;

use App\Models\Pendaftaran;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pendaftaran::firstOrCreate([
            'user_id' => 3,
            'beasiswa_id' => 1,
            'tanggal_daftar' => now(),
            'status_verifikasi' => 'diproses',
            'catatan_verifikasi' => null,
        ]);
    }
}
