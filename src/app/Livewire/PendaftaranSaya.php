<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class PendaftaranSaya extends Component
{
    public function render(): View
    {
        // 1. Ambil ID pengguna yang sedang login
        $userId = Auth::id();

        // 2. Ambil semua data pendaftaran milik pengguna tersebut
        // 'with' digunakan untuk mengambil data relasi (beasiswa) secara efisien
        $pendaftarans = \App\Models\Pendaftaran::where('user_id', $userId)
            ->with('beasiswa')
            ->orderBy('tanggal_daftar', 'desc') // Urutkan dari yang terbaru
            ->get();

        // 3. Kirim data ke view dan atur layout
        return view('livewire.pendaftaran-saya', [
            'pendaftarans' => $pendaftarans
        ]);
    }
}
