<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dokumen;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class DokumenController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/dokumen",
     *     summary="Menampilkan semua dokumen",
     *     tags={"Dokumen"},
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil daftar dokumen"
     *     )
     * )
     */
    public function index(): Response
    {
        $dokumen = Dokumen::all();
        return response()->json($dokumen);
    }

    /**
     * @OA\Post(
     *     path="/api/dokumen",
     *     summary="Upload dokumen baru",
     *     tags={"Dokumen"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 required={"pendaftaran_id"},
     *                 @OA\Property(property="pendaftaran_id", type="integer", example=1),
     *                 @OA\Property(property="ktm", type="string", format="binary"),
     *                 @OA\Property(property="krs", type="string", format="binary"),
     *                 @OA\Property(property="khs", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Dokumen berhasil disimpan"
     *     )
     * )
     */
    public function store(Request $request): Response
    {
        $validatedData = $request->validate([
            'pendaftaran_id' => 'required|exists:pendaftarans,id',
            'ktm' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'krs' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'khs' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $paths = [];
        if ($request->hasFile('ktm')) {
            $paths['ktm'] = $request->file('ktm')->store('dokumen/ktm');
        }
        if ($request->hasFile('krs')) {
            $paths['krs'] = $request->file('krs')->store('dokumen/krs');
        }
        if ($request->hasFile('khs')) {
            $paths['khs'] = $request->file('khs')->store('dokumen/khs');
        }

        $dokumen = Dokumen::create([
            'pendaftaran_id' => $validatedData['pendaftaran_id'],
            'ktm' => $paths['ktm'] ?? null,
            'krs' => $paths['krs'] ?? null,
            'khs' => $paths['khs'] ?? null,
        ]);

        return response()->json($dokumen, 201);
    }

    /**
     * @OA\Get(
     *     path="/api/dokumen/{id}",
     *     summary="Menampilkan detail dokumen",
     *     tags={"Dokumen"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Berhasil mengambil detail dokumen"
     *     )
     * )
     */
    public function show(Dokumen $dokumen): Response
    {
        return response()->json($dokumen);
    }

    /**
     * @OA\Post(
     *     path="/api/dokumen/{id}",
     *     summary="Memperbarui dokumen (upload ulang)",
     *     tags={"Dokumen"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 @OA\Property(property="ktm", type="string", format="binary"),
     *                 @OA\Property(property="krs", type="string", format="binary"),
     *                 @OA\Property(property="khs", type="string", format="binary")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Dokumen berhasil diperbarui"
     *     )
     * )
     */
    public function update(Request $request, Dokumen $dokumen): Response
    {
        $validatedData = $request->validate([
            'ktm' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'krs' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'khs' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        if ($request->hasFile('ktm')) {
            if ($dokumen->ktm) Storage::delete($dokumen->ktm);
            $dokumen->ktm = $request->file('ktm')->store('dokumen/ktm');
        }
        if ($request->hasFile('krs')) {
            if ($dokumen->krs) Storage::delete($dokumen->krs);
            $dokumen->krs = $request->file('krs')->store('dokumen/krs');
        }
        if ($request->hasFile('khs')) {
            if ($dokumen->khs) Storage::delete($dokumen->khs);
            $dokumen->khs = $request->file('khs')->store('dokumen/khs');
        }

        $dokumen->save();
        return response()->json($dokumen);
    }

    /**
     * @OA\Delete(
     *     path="/api/dokumen/{id}",
     *     summary="Menghapus dokumen",
     *     tags={"Dokumen"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Dokumen berhasil dihapus"
     *     )
     * )
     */
    public function destroy(Dokumen $dokumen): Response
    {
        if ($dokumen->ktm) Storage::delete($dokumen->ktm);
        if ($dokumen->krs) Storage::delete($dokumen->krs);
        if ($dokumen->khs) Storage::delete($dokumen->khs);

        $dokumen->delete();
        return response()->json(null, 204);
    }
}
