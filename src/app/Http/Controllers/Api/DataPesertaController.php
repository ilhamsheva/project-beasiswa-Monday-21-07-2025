<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DataPeserta;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class DataPesertaController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/data-peserta",
     *     summary="Menampilkan semua data peserta",
     *     tags={"Data Peserta"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil data peserta"
     *     )
     * )
     */
    public function index(): Response
    {
        $dataPeserta = DataPeserta::all();
        return response()->json($dataPeserta);
    }

    /**
     * @OA\Post(
     *     path="/api/data-peserta",
     *     summary="Menyimpan data peserta baru",
     *     tags={"Data Peserta"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "nim", "jurusan", "angkatan"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="nim", type="string", example="20230801219"),
     *             @OA\Property(property="jurusan", type="string", example="Teknik Informatika"),
     *             @OA\Property(property="angkatan", type="integer", example=2023)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Data peserta berhasil dibuat"
     *     )
     * )
     */
    public function store(Request $request): Response
    {
        $validatedData = $request->validate([
            'user_id' => 'required|exists:users,id',
            'nim' => 'required|string|unique:data_peserta,nim|max:255',
            'jurusan' => 'required|string|max:255',
            'angkatan' => 'required|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        $dataPeserta = DataPeserta::create($validatedData);
        return response()->json($dataPeserta, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/data-peserta/{id}",
     *     summary="Menampilkan detail data peserta",
     *     tags={"Data Peserta"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil detail data peserta"
     *     )
     * )
     */
    public function show(DataPeserta $dataPeserta): Response
    {
        return response()->json($dataPeserta);
    }

    /**
     * @OA\Put(
     *     path="/api/data-peserta/{id}",
     *     summary="Memperbarui data peserta",
     *     tags={"Data Peserta"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="nim", type="string", example="20230801219"),
     *             @OA\Property(property="jurusan", type="string", example="Sistem Informasi"),
     *             @OA\Property(property="angkatan", type="integer", example=2022)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Data peserta berhasil diperbarui"
     *     )
     * )
     */
    public function update(Request $request, DataPeserta $dataPeserta): Response
    {
        $validatedData = $request->validate([
            'nim' => 'sometimes|required|string|unique:data_peserta,nim,' . $dataPeserta->id . '|max:255',
            'jurusan' => 'sometimes|required|string|max:255',
            'angkatan' => 'sometimes|required|integer|min:1900|max:' . (date('Y') + 1),
        ]);

        $dataPeserta->update($validatedData);
        return response()->json($dataPeserta);
    }

    /**
     * @OA\Delete(
     *     path="/api/data-peserta/{id}",
     *     summary="Menghapus data peserta",
     *     tags={"Data Peserta"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Data peserta berhasil dihapus"
     *     )
     * )
     */
    public function destroy(DataPeserta $dataPeserta): Response
    {
        $dataPeserta->delete();
        return response()->json(null, 204);
    }
}
