@extends('components.layouts.app')

@section('content')
    <div>
        <div class="container">

            {{-- Judul Halaman dan Sapaan Personal --}}
            <div class="my-4">
                <h1 class="h1 fw-bold text-uppercase text-gray-800">
                    Selamat Datang, {{ Auth::user()->nama ?? Auth::user()->name }}!
                </h1>
            </div>

            {{-- Baris untuk Kartu Ringkasan --}}
            <div class="row">

                <!-- Kartu Ringkasan: Status Pendaftaran -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Status Pendaftaran Terakhir</h6>
                        </div>
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">Sedang Diproses</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-file-earmark-text-fill fs-2 text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kartu Ringkasan: Beasiswa Aktif -->
                <div class="col-xl-6 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Beasiswa Tersedia</h6>
                        </div>
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">3 Program Dibuka</div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-mortarboard-fill fs-2 text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Area untuk Pengumuman Penting --}}
            <div class="row">
                <div class="col-lg-12 mb-4">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Pengumuman Penting</h6>
                        </div>
                        <div class="card-body">
                            <p>Saat ini belum ada pengumuman baru. Silakan periksa halaman ini secara berkala untuk
                                mendapatkan informasi terbaru seputar program beasiswa.</p>
                            <p class="mb-0">Pastikan data profil dan dokumen Anda selalu yang terbaru sebelum melakukan
                                pendaftaran.</p>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        {{-- Menambahkan sedikit style kustom untuk kartu --}}
        @push('styles')
            <style>
                .card .border-left-primary {
                    border-left: .25rem solid #0d6efd !important;
                }

                .text-gray-300 {
                    color: #dddfeb !important;
                }

                .text-gray-800 {
                    color: #5a5c69 !important;
                }

                .font-weight-bold {
                    font-weight: 700 !important;
                }
            </style>
        @endpush
    </div>
@endsection
