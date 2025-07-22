<div class="d-flex" id="app">

    {{-- Sidebar (Hanya tampil jika login) --}}
    @auth
    <div class="sidebar d-flex flex-column p-3" id="sidebar">
        <a href="{{ route('dashboard') }}" class="logo d-block text-center">Sistem Beasiswa</a>
        <hr class="text-secondary">
        <ul class="nav nav-pills flex-column mb-auto">
            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house-door-fill"></i> Beranda
                </a>
            </li>
            <li>
                <a href="{{ route('beasiswa') }}" class="nav-link {{ request()->routeIs('beasiswa') ? 'active' : '' }}">
                    <i class="bi bi-mortarboard-fill"></i> Daftar Beasiswa
                </a>
            </li>
            <li>
                <a href="{{ route('daftar-saya') }}" class="nav-link {{ request()->routeIs('daftar-saya') ? 'active' : '' }}">
                    <i class="bi bi-file-earmark-text-fill"></i> Pendaftaran Saya
                </a>
            </li>
        </ul>
    </div>
    @endauth

    {{-- Konten Utama --}}
    <div class="main-content flex-grow-1">

        {{-- Header --}}
        @auth
        <header class="main-header bg-white shadow-sm p-3 d-flex justify-content-between align-items-center">
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

        @guest
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <div class="container-fluid">
                <button class="btn btn-primary d-md-none" type="button" id="sidebar-toggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="collapse navbar-collapse">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Selamat Datang, Peserta!</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        @endguest

        {{-- Area Konten Halaman --}}
        <main class="p-4">
            {{-- Optional konten default --}}
            @hasSection('content')
                @yield('content')
            @else
                <h2 class="fs-4 fw-semibold mb-4">Dasbor Peserta</h2>
                <div class="card shadow-sm">
                    <div class="card-body">
                        <p class="card-text">Ini adalah area konten utama. Anda dapat melihat menu navigasi di sebelah kiri.</p>
                    </div>
                </div>
            @endif
        </main>

    </div>
</div>
