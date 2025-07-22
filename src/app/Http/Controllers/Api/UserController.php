<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User; // Tambahkan model User
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     summary="Menampilkan daftar semua pengguna",
     *     tags={"User"},
     *     @OA\Response(
     *         response=200,
     *         description="Daftar pengguna berhasil diambil"
     *     )
     * )
     */
    public function index(): Response
    {
        // Jika ingin membatasi hanya super admin:
        // if (!auth()->user() || auth()->user()->role !== 'superadmin') {
        //     return response()->json(['message' => 'Unauthorized'], 403);
        // }

        $users = User::all();
        return response()->json($users);
    }
}
