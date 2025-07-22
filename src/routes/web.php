<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PendaftaranController; // Pastikan ini diimport
use App\Livewire\Beranda;
use App\Livewire\DaftarBeasiswa;
use App\Livewire\PendaftaranSaya; // Tetap diimport jika masih digunakan di tempat lain

/**
 * NOTE: Jangan hapus bagian ini jika Livewire digunakan di subfolder domain
 */
Livewire::setUpdateRoute(function ($handle) {
    return Route::post(config('app.asset_prefix') . '/livewire/update', $handle);
});

Livewire::setScriptRoute(function ($handle) {
    return Route::get(config('app.asset_prefix') . '/livewire/livewire.js', $handle);
});
/**
 * END
 */

// Autentikasi
Auth::routes();

// Redirect default ke login jika belum login
Route::get('/', function () {
    return redirect()->route('login');
});

// Halaman Dashboard (Livewire)
Route::get('/dashboard', Beranda::class)
    ->middleware('auth')
    ->name('dashboard');

// Grup rute yang memerlukan autentikasi
Route::middleware('auth')->group(function () {
    // Daftar Beasiswa (Livewire)
    Route::get('/daftar-beasiswa', DaftarBeasiswa::class)->name('beasiswa');

    // Form submit dari modal Bootstrap (ke Controller PendaftaranController@store)
    // Menggunakan 'store' sesuai dengan nama metode di PendaftaranController
    Route::post('/pendaftaran', [PendaftaranController::class, 'store'])
        ->name('pendaftaran.store'); // Mengubah nama rute menjadi 'pendaftaran.store'

    // Riwayat Pendaftaran (ke Controller PendaftaranController@riwayat)
    // MENGUBAH INI menjadi GET dan menunjuk ke Controller
    Route::get('/daftar-saya', [PendaftaranController::class, 'riwayat'])
        ->name('daftar-saya');
});
