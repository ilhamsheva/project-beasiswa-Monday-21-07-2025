<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Beasiswa</title>
    <!-- Vendor CSS Files -->
    <link href="{{ asset('front/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('front/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Livewire Styles -->
    @livewireStyles
    {{-- CSS Kustom untuk Layout --}}
    <style>
        body { font-family: 'Inter', sans-serif; overflow-x: hidden; }
        .sidebar { width: 250px; min-height: 100vh; background-color: #212529; color: #fff; transition: all 0.3s; }
        .main-content { transition: all 0.3s; }
        .sidebar .nav-link { color: #adb5bd; padding: 10px 15px; display: flex; align-items: center; border-radius: .25rem; }
        .sidebar .nav-link .bi { margin-right: 15px; font-size: 1.2rem; }
        .sidebar .nav-link:hover { color: #fff; background-color: #343a40; }
        .sidebar .nav-link.active { color: #fff; background-color: #0d6efd; }
        .sidebar .logo { font-size: 1.5rem; font-weight: 700; color: #fff; text-decoration: none; padding-bottom: 1rem; margin-bottom: 1rem; border-bottom: 1px solid #495057; }

        /* Jika tidak login, konten akan full width */
        @guest
        .main-content { width: 100%; }
        @endguest

        /* Jika login, konten akan memiliki margin kiri untuk sidebar */
        @auth
        .main-content { margin-left: 250px; }
        @endauth

        @media (max-width: 768px) {
            .main-content { margin-left: 0 !important; }
            .sidebar { position: fixed; z-index: 1000; left: -250px; }
            .sidebar.active { left: 0; }
        }
    </style>
    @stack('styles')
</head>

<body>
    <div class="d-flex" id="app">

        {{-- Sidebar hanya akan ditampilkan jika pengguna sudah login --}}
        @auth
            <div class="sidebar d-flex flex-column p-3" id="sidebar">
                <a href="{{ route('dashboard') }}" class="logo d-block text-center">Sistem Beasiswa</a>
                <hr class="text-secondary">
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item"><a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="bi bi-house-door-fill"></i> Beranda</a></li>
                    <li><a href="{{route('beasiswa')}}" class="nav-link {{ request()->routeIs('beasiswa') ? 'active' : '' }}"><i class="bi bi-mortarboard-fill"></i> Daftar Beasiswa</a></li>
                    <li><a href="{{route('daftar-saya')}}" class="nav-link {{ request()->routeIs('daftar-saya') ? 'active' : '' }}"><i class="bi bi-file-earmark-text-fill"></i> Pendaftaran Saya</a></li>
                </ul>
            </div>
        @endauth

        {{-- Area Konten Utama --}}
        <div class="main-content flex-grow-1">

            {{-- Header juga hanya akan ditampilkan jika pengguna sudah login --}}
            @auth
            <header class="main-header bg-white shadow-sm p-3 d-flex justify-content-between align-items: center">
                <button class="btn btn-primary d-md-none" type="button" id="sidebar-toggle" aria-label="Toggle Sidebar">
                    <i class="bi bi-list"></i>
                </button>
                <div class="flex-grow-1"></div>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->nama ?? Auth::user()->name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                    Logout
                                </a>
                            </form>
                        </div>
                    </li>
                </ul>
            </header>
            @endauth

            {{-- Konten dari halaman akan dirender di sini --}}
            <main class="@auth p-4 @endauth">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('front/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- Link ke SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    {{-- Tambahkan script vendor lain jika perlu --}}

    <!-- Script untuk Toggle Sidebar -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebar-toggle');
            const sidebar = document.getElementById('sidebar');
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', () => sidebar.classList.toggle('active'));
            }

            // Menampilkan SweetAlert2 berdasarkan pesan flash sesi
            @if (session()->has('message'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('message') }}",
                    showConfirmButton: false,
                    timer: 2500
                });
            @endif

            @if (session()->has('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    text: "{{ session('error') }}",
                    showConfirmButton: true,
                });
            @endif
        });
    </script>
    @stack('script')
    @livewireScripts
</body>
</html>
