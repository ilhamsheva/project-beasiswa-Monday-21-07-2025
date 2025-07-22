<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BeasiswaController;
use App\Http\Controllers\Api\DataPesertaController;
use App\Http\Controllers\Api\DokumenController;
use App\Http\Controllers\Api\PendaftaranController;
use App\Http\Controllers\Api\UserController; // Asumsi Anda juga memiliki UserController

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rute default untuk mendapatkan user yang sedang login (biasanya dilindungi oleh Sanctum)
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Definisi rute resource API untuk setiap controller Anda.
// Ini akan secara otomatis membuat rute untuk operasi:
// GET /api/{resource}          -> index
// POST /api/{resource}         -> store
// GET /api/{resource}/{id}     -> show
// PUT/PATCH /api/{resource}/{id} -> update
// DELETE /api/{resource}/{id}  -> destroy
Route::apiResources([
    'beasiswa' => BeasiswaController::class,
    'data-peserta' => DataPesertaController::class, // Menggunakan kebab-case untuk URL
    'dokumen' => DokumenController::class,
    'pendaftaran' => PendaftaranController::class,
    'users' => UserController::class, // Sertakan jika Anda memiliki UserController
]);

