@extends('components.layouts.app')

@section('content')
    <div class="container">
        @if (session()->has('message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('message') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="h3 text-gray-800 mb-0">Daftar Beasiswa</h1>
        </div>

        <div class="row">
            @forelse ($beasiswas as $beasiswa)
                <div class="col-md-6 col-lg-6 mb-4">
                    <div class="card h-100 shadow-sm">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title fw-bold">{{ $beasiswa->nama_beasiswa }}</h5>

                            <div class="card-text text-muted small flex-grow-1">
                                @if (strlen($beasiswa->deskripsi) > 150)
                                    <span id="short-desc-{{ $beasiswa->id }}">
                                        {{ Str::limit($beasiswa->deskripsi, 150) }}
                                        <a href="javascript:void(0)" onclick="toggleDescription({{ $beasiswa->id }})" class="read-more-link">Baca selengkapnya</a>
                                    </span>
                                    <span id="full-desc-{{ $beasiswa->id }}" class="d-none">
                                        {{ $beasiswa->deskripsi }}
                                        <a href="javascript:void(0)" onclick="toggleDescription({{ $beasiswa->id }})" class="read-more-link">Sembunyikan</a>
                                    </span>
                                @else
                                    {{ $beasiswa->deskripsi }}
                                @endif
                            </div>

                            <div class="mt-3">
                                <p class="mb-1 small"><strong>Periode:</strong></p>
                                <p class="mb-0 small"><i class="bi bi-calendar-check"></i>
                                    {{ $beasiswa->periode_buka->isoFormat('D MMMM Y') }} -
                                    {{ $beasiswa->periode_tutup->isoFormat('D MMMM Y') }}</p>
                            </div>
                        </div>
                        <div class="card-footer bg-white border-top-0 pt-0">
                            @php $isBuka = now()->between($beasiswa->periode_buka, $beasiswa->periode_tutup); @endphp
                            <div class="d-flex justify-content-between align-items-center">
                                @if ($isBuka)
                                    <span class="badge bg-success">Pendaftaran Dibuka</span>
                                    <button class="btn btn-primary btn-sm btn-daftar" data-bs-toggle="modal" data-bs-target="#pendaftaranModal" data-beasiswa-id="{{ $beasiswa->id }}" data-beasiswa-nama="{{ $beasiswa->nama_beasiswa }}">
                                        Daftar Sekarang
                                    </button>
                                @else
                                    <span class="badge bg-danger">Pendaftaran Ditutup</span>
                                    <button class="btn btn-secondary btn-sm" disabled>Ditutup</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="alert alert-info text-center">Saat ini belum ada program beasiswa yang tersedia.</div>
                </div>
            @endforelse
        </div>
    </div>

    <div class="modal fade" id="pendaftaranModal" tabindex="-1" aria-labelledby="pendaftaranModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="pendaftaranModalLabel">Form Pendaftaran: <span id="modalBeasiswaNama"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('pendaftaran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="beasiswa_id" value="{{ $beasiswa->id }}">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nim" class="form-label">NIM</label>
                                <input type="text" class="form-control @error('nim') is-invalid @enderror" id="nim" name="nim" value="{{ old('nim') }}" required>
                                @error('nim')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="jurusan" class="form-label">Jurusan</label>
                                <input type="text" class="form-control @error('jurusan') is-invalid @enderror" id="jurusan" name="jurusan" value="{{ old('jurusan') }}" required>
                                @error('jurusan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="angkatan" class="form-label">Angkatan</label>
                                <input type="number" class="form-control @error('angkatan') is-invalid @enderror" id="angkatan" name="angkatan" value="{{ old('angkatan') }}" placeholder="Contoh: 2021" required>
                                @error('angkatan')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="ktm" class="form-label">Upload KTM</label>
                                <input type="file" class="form-control @error('ktm') is-invalid @enderror" id="ktm" name="ktm" required>
                                @error('ktm')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="krs" class="form-label">Upload KRS</label>
                                <input type="file" class="form-control @error('krs') is-invalid @enderror" id="krs" name="krs" required>
                                @error('krs')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="khs" class="form-label">Upload KHS</label>
                                <input type="file" class="form-control @error('khs') is-invalid @enderror" id="khs" name="khs" required>
                                @error('khs')<span class="invalid-feedback">{{ $message }}</span>@enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Ajukan Pendaftaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            function toggleDescription(id) {
                const shortDesc = document.getElementById('short-desc-' + id);
                const fullDesc = document.getElementById('full-desc-' + id);
                shortDesc.classList.toggle('d-none');
                fullDesc.classList.toggle('d-none');
            }

            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('pendaftaranModal');

                modal.addEventListener('show.bs.modal', function (event) {
                    const button = event.relatedTarget;
                    const beasiswaId = button?.getAttribute('data-beasiswa-id');
                    const beasiswaNama = button?.getAttribute('data-beasiswa-nama');

                    document.getElementById('beasiswa_id_input').value = beasiswaId;
                    document.getElementById('modalBeasiswaNama').textContent = beasiswaNama;
                    document.getElementById('pendaftaranModalLabel').textContent = 'Form Pendaftaran: ' + beasiswaNama;
                });

                @if ($errors->any() || session('error'))
                    const bootstrapModal = new bootstrap.Modal(modal);
                    bootstrapModal.show();
                @endif
            });
        </script>
    @endpush

    @push('styles')
        <style>
            .read-more-link {
                color: #0d6efd;
                font-weight: 500;
                text-decoration: none;
                cursor: pointer;
            }
            .read-more-link:hover {
                text-decoration: underline;
            }
        </style>
    @endpush
@endsection
