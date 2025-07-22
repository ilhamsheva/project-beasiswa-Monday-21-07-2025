<?php

namespace Database\Seeders;

use App\Models\DataPeserta;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DataPesertaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DataPeserta::firstOrCreate([
                'user_id' => 3,
                'nim' => '1234567890',
                'jurusan' => 'Teknik Informatika',
                'angkatan' => 2022,
        ]);
    }
}
