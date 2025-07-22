<?php

namespace Database\Seeders;

use App\Models\Dokumen;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DokumenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Dokumen::firstOrCreate([
            'pendaftaran_id' => 1,
            'ktm' => 'ktm_1.pdf',
            'krs' => 'krs_1.pdf',
            'khs' => 'khs_1.pdf',
        ]);
    }
}
