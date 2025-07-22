<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Beasiswa;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BeasiswaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/beasiswa",
     *     summary="Menampilkan semua program beasiswa",
     *     tags={"Beasiswa"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data beasiswa"
     *     )
     * )
     */
    public function index(): Response
    {
        $beasiswa = Beasiswa::all();
        return response()->json($beasiswa);
    }

    /**
     * @OA\Post(
     *     path="/api/beasiswa",
     *     summary="Menyimpan program beasiswa baru",
     *     tags={"Beasiswa"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nama_beasiswa", "periode_buka", "periode_tutup"},
     *             @OA\Property(property="nama_beasiswa", type="string", example="Beasiswa Unggulan"),
     *             @OA\Property(property="deskripsi", type="string", example="Beasiswa untuk mahasiswa berprestasi"),
     *             @OA\Property(property="periode_buka", type="string", format="date", example="2025-08-01"),
     *             @OA\Property(property="periode_tutup", type="string", format="date", example="2025-09-01"),
     *             @OA\Property(property="status", type="string", example="aktif")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Beasiswa berhasil dibuat"
     *     )
     * )
     */
    public function store(Request $request): Response
    {
        $validatedData = $request->validate([
            'nama_beasiswa' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_buka' => 'required|date',
            'periode_tutup' => 'required|date|after_or_equal:periode_buka',
            'status' => 'nullable|string',
        ]);

        $beasiswa = Beasiswa::create($validatedData);
        return response()->json($beasiswa, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/beasiswa/{id}",
     *     summary="Menampilkan detail program beasiswa",
     *     tags={"Beasiswa"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil detail beasiswa"
     *     )
     * )
     */
    public function show(Beasiswa $beasiswa): Response
    {
        return response()->json($beasiswa);
    }

    /**
     * @OA\Put(
     *     path="/api/beasiswa/{id}",
     *     summary="Memperbarui program beasiswa",
     *     tags={"Beasiswa"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="nama_beasiswa", type="string", example="Beasiswa Update"),
     *             @OA\Property(property="deskripsi", type="string", example="Deskripsi terbaru"),
     *             @OA\Property(property="periode_buka", type="string", format="date", example="2025-08-10"),
     *             @OA\Property(property="periode_tutup", type="string", format="date", example="2025-09-10"),
     *             @OA\Property(property="status", type="string", example="nonaktif")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Beasiswa berhasil diperbarui"
     *     )
     * )
     */
    public function update(Request $request, Beasiswa $beasiswa): Response
    {
        $validatedData = $request->validate([
            'nama_beasiswa' => 'sometimes|required|string|max:255',
            'deskripsi' => 'nullable|string',
            'periode_buka' => 'sometimes|required|date',
            'periode_tutup' => 'sometimes|required|date|after_or_equal:periode_buka',
            'status' => 'nullable|string',
        ]);

        $beasiswa->update($validatedData);
        return response()->json($beasiswa);
    }

    /**
     * @OA\Delete(
     *     path="/api/beasiswa/{id}",
     *     summary="Menghapus program beasiswa",
     *     tags={"Beasiswa"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Beasiswa berhasil dihapus"
     *     )
     * )
     */
    public function destroy(Beasiswa $beasiswa): Response
    {
        $beasiswa->delete();
        return response()->json(null, 204);
    }
}
