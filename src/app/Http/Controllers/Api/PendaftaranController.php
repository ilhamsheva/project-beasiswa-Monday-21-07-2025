<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PendaftaranController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pendaftaran",
     *     summary="Menampilkan semua data pendaftaran beasiswa",
     *     tags={"Pendaftaran"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data pendaftaran"
     *     )
     * )
     */
    public function index(): Response
    {
        $pendaftaran = Pendaftaran::all();
        return response()->json($pendaftaran);
    }

    /**
     * @OA\Post(
     *     path="/api/pendaftaran",
     *     summary="Mendaftarkan pengguna ke program beasiswa",
     *     tags={"Pendaftaran"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "beasiswa_id"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="beasiswa_id", type="integer", example=2),
     *             @OA\Property(property="status_verifikasi", type="string", example="diproses"),
     *             @OA\Property(property="catatan_verifikasi", type="string", example="Dokumen belum lengkap")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Pendaftaran berhasil disimpan"
     *     )
     * )
     */
    public function store(Request $request): Response
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'beasiswa_id' => 'required|exists:beasiswas,id',
            'status_verifikasi' => 'nullable|string|in:diproses,disetujui,ditolak',
            'catatan_verifikasi' => 'nullable|string',
        ]);

        $validatedData['status_verifikasi'] = $validatedData['status_verifikasi'] ?? 'diproses';

        $pendaftaran = Pendaftaran::create($validatedData);

        return response()->json($pendaftaran, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/pendaftaran/{id}",
     *     summary="Menampilkan detail pendaftaran berdasarkan ID",
     *     tags={"Pendaftaran"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detail pendaftaran ditemukan"
     *     )
     * )
     */
    public function show(Pendaftaran $pendaftaran): Response
    {
        return response()->json($pendaftaran);
    }

    /**
     * @OA\Put(
     *     path="/api/pendaftaran/{id}",
     *     summary="Memperbarui status dan catatan verifikasi pendaftaran",
     *     tags={"Pendaftaran"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="status_verifikasi", type="string", example="disetujui"),
     *             @OA\Property(property="catatan_verifikasi", type="string", example="Dokumen lengkap")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data pendaftaran berhasil diperbarui"
     *     )
     * )
     */
    public function update(Request $request, Pendaftaran $pendaftaran): Response
    {
        $validatedData = $request->validate([
            'status_verifikasi' => 'sometimes|required|string|in:diproses,disetujui,ditolak',
            'catatan_verifikasi' => 'nullable|string',
        ]);

        $pendaftaran->update($validatedData);

        return response()->json($pendaftaran);
    }

    /**
     * @OA\Delete(
     *     path="/api/pendaftaran/{id}",
     *     summary="Menghapus data pendaftaran",
     *     tags={"Pendaftaran"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Pendaftaran berhasil dihapus"
     *     )
     * )
     */
    public function destroy(Pendaftaran $pendaftaran): Response
    {
        $pendaftaran->delete();
        return response()->json(null, 204);
    }
}
