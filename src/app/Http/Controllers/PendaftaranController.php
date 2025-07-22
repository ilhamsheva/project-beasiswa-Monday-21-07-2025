<?php

namespace App\Http\Controllers;

use App\Models\DataPeserta;
use App\Models\Dokumen;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // Import Storage Facade

class PendaftaranController extends Controller
{
    public function store(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'beasiswa_id' => 'required|exists:beasiswas,id', // Pastikan beasiswa_id ada di tabel beasiswas
            'nim' => 'required|string|max:100',
            'jurusan' => 'required|string|max:255',
            'angkatan' => 'required|integer|digits:4|min:1900|max:' . (date('Y') + 1),
            'ktm' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Maks 2MB
            'krs' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'khs' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ], [
            'beasiswa_id.required' => 'ID Beasiswa tidak ditemukan.',
            'beasiswa_id.exists' => 'Beasiswa tidak valid.',
            'nim.required' => 'NIM wajib diisi.',
            'nim.string' => 'NIM harus berupa teks.',
            'nim.max' => 'NIM tidak boleh lebih dari :max karakter.',
            'jurusan.required' => 'Jurusan wajib diisi.',
            'angkatan.required' => 'Angkatan wajib diisi.',
            'angkatan.integer' => 'Angkatan harus berupa angka.',
            'angkatan.digits' => 'Angkatan harus 4 digit angka (tahun).',
            'angkatan.min' => 'Angkatan minimal tahun :min.',
            'angkatan.max' => 'Angkatan maksimal tahun :max.',
            'ktm.required' => 'File KTM wajib diupload.',
            'ktm.file' => 'KTM harus berupa file.',
            'ktm.mimes' => 'Format file KTM harus PDF, JPG, JPEG, atau PNG.',
            'ktm.max' => 'Ukuran file KTM tidak boleh lebih dari 2MB.',
            'krs.required' => 'File KRS wajib diupload.',
            'krs.file' => 'KRS harus berupa file.',
            'krs.mimes' => 'Format file KRS harus PDF, JPG, JPEG, atau PNG.',
            'krs.max' => 'Ukuran file KRS tidak boleh lebih dari 2MB.',
            'khs.required' => 'File KHS wajib diupload.',
            'khs.file' => 'KHS harus berupa file.',
            'khs.mimes' => 'Format file KHS harus PDF, JPG, JPEG, atau PNG.',
            'khs.max' => 'Ukuran file KHS tidak boleh lebih dari 2MB.',
        ]);

        $user = Auth::user();

        if (!$user) {
            return redirect()->back()->with('error', 'Anda harus login untuk mengajukan pendaftaran.');
        }

        DB::beginTransaction();

        try {
            // 2. Simpan atau update data peserta
            $dataPeserta = DataPeserta::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nim' => $request->nim,
                    'jurusan' => $request->jurusan,
                    'angkatan' => $request->angkatan,
                ]
            );

            // 3. Cek apakah user sudah mendaftar beasiswa ini sebelumnya
            $existingPendaftaran = Pendaftaran::where('user_id', $user->id)
                ->where('beasiswa_id', $request->beasiswa_id)
                ->first();

            if ($existingPendaftaran) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Anda sudah mendaftar untuk beasiswa ini.');
            }

            // 4. Buat entri pendaftaran baru
            $pendaftaran = Pendaftaran::create([
                'user_id' => $user->id,
                'beasiswa_id' => $request->beasiswa_id,
                'status_verifikasi' => 'diproses',
            ]);

            if (!$pendaftaran) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Gagal membuat entri pendaftaran.');
            }

            // 5. Upload file dan simpan path-nya
            $pathKtm = $request->file('ktm')->store('dokumen/ktm', 'public');
            $pathKrs = $request->file('krs')->store('dokumen/krs', 'public');
            $pathKhs = $request->file('khs')->store('dokumen/khs', 'public');

            // 6. Buat entri dokumen baru yang terkait dengan pendaftaran
            Dokumen::create([
                'pendaftaran_id' => $pendaftaran->id,
                'ktm' => $pathKtm,
                'krs' => $pathKrs,
                'khs' => $pathKhs,
            ]);

            DB::commit();

            return redirect()->route('beasiswa')->with('message', 'Pendaftaran berhasil diajukan!');

        } catch (\Exception $e) {
            DB::rollBack();
            // Hapus file yang mungkin sudah terupload sebagian jika terjadi error
            if (isset($pathKtm) && Storage::disk('public')->exists($pathKtm)) {
                Storage::disk('public')->delete($pathKtm);
            }
            if (isset($pathKrs) && Storage::disk('public')->exists($pathKrs)) {
                Storage::disk('public')->delete($pathKrs);
            }
            if (isset($pathKhs) && Storage::disk('public')->exists($pathKhs)) {
                Storage::disk('public')->delete($pathKhs);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan saat menyimpan pendaftaran: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan riwayat pendaftaran untuk pengguna yang sedang login.
     *
     * @return \Illuminate\View\View
     */
    public function riwayat()
    {
        $user = Auth::user();

        if (!$user) {
            // Jika user tidak login, arahkan ke halaman login
            return redirect()->route('login')->with('error', 'Anda harus login untuk melihat riwayat pendaftaran.');
        }

        // Ambil riwayat pendaftaran untuk user yang sedang login, dengan eager loading relasi 'beasiswa'
        $riwayatPendaftaran = Pendaftaran::where('user_id', $user->id)
            ->with('beasiswa') // Eager load relasi beasiswa
            ->get();

        return view('livewire.pendaftaran-saya', compact('riwayatPendaftaran'));
    }
}
