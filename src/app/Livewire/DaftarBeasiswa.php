<?php

namespace App\Livewire;

use App\Models\Beasiswa;
use App\Models\DataPeserta;
use App\Models\Dokumen;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;

class DaftarBeasiswa extends Component
{
    use WithFileUploads;

    public $beasiswas; // Properti untuk menampilkan daftar beasiswa

    // Properti untuk Modal Form Pendaftaran
    public $beasiswaId;
    public $namaBeasiswa;
    public $showModal = true; // Livewire yang mengelola visibilitas modal

    // Properti yang di-binding ke form
    public $nim;
    public $jurusan;
    public $angkatan;
    public $ktm;
    public $krs;
    public $khs;

    // Listener untuk event dari JavaScript (dari tombol di view)
    // DIHAPUS: Tidak lagi mendengarkan event JS, karena wire:click akan memanggil method langsung
    protected $listeners = ['bukaPendaftaran'];

    // Aturan validasi
    protected function rules()
    {
        return [
            'nim' => 'required|string|max:100',
            'jurusan' => 'required|string|max:255',
            'angkatan' => 'required|integer|digits:4|min:1900|max:' . (date('Y') + 1),
            'ktm' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Maks 2MB
            'krs' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'khs' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ];
    }

    // Pesan validasi kustom
    protected $messages = [
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
    ];


    // Metode mount akan dipanggil saat komponen diinisialisasi
    public function mount()
    {
        $this->beasiswas = Beasiswa::all(); // Ambil daftar beasiswa
        $this->namaBeasiswa = ''; // Inisialisasi properti modal
        $this->resetFormProperties(); // Panggil untuk memastikan form bersih saat load awal
    }

    // Fungsi untuk membuka modal pendaftaran (dipanggil langsung oleh wire:click)
    public function bukaPendaftaran($beasiswaId)
    {
        $this->resetFormProperties(); // Reset form setiap kali modal dibuka
        $this->beasiswaId = $beasiswaId;
        $beasiswa = Beasiswa::find($this->beasiswaId);

        if ($beasiswa instanceof Beasiswa) {
            $this->namaBeasiswa = $beasiswa->nama_beasiswa ?? $beasiswa->nama ?? '';
        } else {
            $this->namaBeasiswa = 'Beasiswa Tidak Ditemukan';
            $this->dispatch('show-error-popup', message: 'Beasiswa yang diminta tidak ditemukan atau tidak valid.');
            // Tidak perlu hide-bootstrap-modal di sini karena modal belum terbuka
            return;
        }

        $user = Auth::user();
        if ($user) {
            $dataPeserta = $user->data_pesertas;
            if ($dataPeserta) {
                $this->nim = $dataPeserta->nim;
                $this->jurusan = $dataPeserta->jurusan;
                $this->angkatan = $dataPeserta->angkatan;
            }
        } else {
            $this->dispatch('show-error-popup', message: 'Anda harus login untuk mendaftar beasiswa.');
            // Tidak perlu hide-bootstrap-modal di sini karena modal belum terbuka
            return;
        }

        $this->resetValidation();
        $this->showModal = true; // KRUSIAL: Livewire yang menampilkan modal
    }

    // Fungsi untuk menyimpan pendaftaran
    public function simpanPendaftaran()
    {
        try {
            $this->validate();

            $user = Auth::user();
            if (!$user) {
                $this->dispatch('show-error-popup', message: 'Anda harus login untuk mengajukan pendaftaran.');
                $this->closeModal(); // Ini akan menyembunyikan modal
                return;
            }

            DB::beginTransaction();

            DataPeserta::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nim' => $this->nim,
                    'jurusan' => $this->jurusan,
                    'angkatan' => $this->angkatan,
                ]
            );

            $existingPendaftaran = Pendaftaran::where('user_id', $user->id)
                                                ->where('beasiswa_id', $this->beasiswaId)
                                                ->first();

            if ($existingPendaftaran) {
                DB::rollBack();
                $this->dispatch('show-error-popup', message: 'Anda sudah mendaftar untuk beasiswa ini.');
                $this->closeModal(); // Ini akan menyembunyikan modal
                return;
            }

            $pendaftaran = Pendaftaran::create([
                'user_id' => $user->id,
                'beasiswa_id' => $this->beasiswaId,
                'status_verifikasi' => 'diproses',
            ]);

            if (!$pendaftaran) {
                DB::rollBack();
                $this->dispatch('show-error-popup', message: 'Gagal membuat entri pendaftaran.');
                $this->closeModal(); // Ini akan menyembunyikan modal
                return;
            }

            $pathKtm = $this->ktm->store('dokumen/ktm', 'public');
            $pathKrs = $this->krs->store('dokumen/krs', 'public');
            $pathKhs = $this->khs->store('dokumen/khs', 'public');

            Dokumen::create([
                'pendaftaran_id' => $pendaftaran->id,
                'ktm' => $pathKtm,
                'krs' => $pathKrs,
                'khs' => $pathKhs,
            ]);

            DB::commit();

            $this->dispatch('show-success-popup', message: 'Pendaftaran berhasil diajukan!');
            $this->resetFormProperties(); // Reset form setelah sukses
            $this->closeModal(); // Ini akan menyembunyikan modal
            $this->beasiswas = Beasiswa::all(); // Refresh daftar beasiswa di halaman

        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            throw $e; // Livewire akan menangani tampilan error validasi
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('show-error-popup', message: 'Terjadi kesalahan saat menyimpan pendaftaran: ' . $e->getMessage());
        }
    }

    // Fungsi untuk menutup modal
    public function closeModal()
    {
        $this->resetFormProperties(); // Reset semua properti form
        $this->resetValidation(); // Reset pesan validasi
        $this->showModal = false; // KRUSIAL: Livewire yang menyembunyikan modal
    }

    // Membantu mereset properti form
    private function resetFormProperties()
    {
        $this->reset(['nim', 'jurusan', 'angkatan', 'ktm', 'krs', 'khs', 'beasiswaId', 'namaBeasiswa']);
    }

    public function render()
    {
        return view('livewire.daftar-beasiswa', [
            'beasiswas' => $this->beasiswas,
        ]);
    }
}
