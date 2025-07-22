<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Beasiswa; // Pastikan model Beasiswa sudah di-import

class BeasiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Beasiswa yang sedang dibuka
        Beasiswa::create([
            'nama_beasiswa' => 'Beasiswa Prestasi Akademik 2025',
            'deskripsi' => 'Diberikan kepada mahasiswa aktif dengan Indeks Prestasi Kumulatif (IPK) di atas 3.50 pada semester sebelumnya. Wajib melampirkan transkrip nilai terakhir.',
            'periode_buka' => '2025-07-01',
            'periode_tutup' => '2025-08-31',
            'status' => 'buka',
        ]);

        // 2. Beasiswa yang sudah ditutup
        Beasiswa::create([
            'nama_beasiswa' => 'Beasiswa Riset dan Inovasi 2025',
            'deskripsi' => 'Pendanaan untuk mahasiswa yang sedang mengerjakan proyek penelitian atau tugas akhir yang inovatif dan berdampak bagi masyarakat.',
            'periode_buka' => '2025-05-01',
            'periode_tutup' => '2025-06-30',
            'status' => 'tutup',
        ]);

        // 3. Beasiswa yang akan datang
        Beasiswa::create([
            'nama_beasiswa' => 'Beasiswa Bantuan UKT Ganjil 2026',
            'deskripsi' => 'Bantuan biaya pendidikan Uang Kuliah Tunggal (UKT) untuk mahasiswa dari keluarga kurang mampu secara ekonomi. Memerlukan Surat Keterangan Tidak Mampu (SKTM).',
            'periode_buka' => '2026-01-15',
            'periode_tutup' => '2026-02-15',
            'status' => 'buka', // Statusnya 'buka', namun aplikasi akan memfilternya berdasarkan tanggal
        ]);
    }
}
