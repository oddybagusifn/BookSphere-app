@php
    $isAdminPage = Request::is('admin*');
@endphp

<nav class="navbar navbar-expand-lg py-3 border-bottom fixed-top" style="background: #fff">
    <div class="container-fluid">
        <!-- Logo -->
        <a href="{{ route('homepage') }}">
            <div class="logo">
                <span class="book fs-1">Book</span><span class="sphere fs-2">Sphere</span><span class="dot">.</span>
            </div>
        </a>

        <!-- Hamburger for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar items -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarMain">

            @if (!$isAdminPage)
            <ul class="navbar-nav me-5 mb-2 mb-lg-0 align-items-center">
                <li class="nav-item"><a class="nav-link px-3" href="#">Beranda</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#">Layanan</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#">Katalog</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#">Kategori</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#">Tentang Kami</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#">Blog</a></li>
            </ul>
            @endif

            @auth
                @php
                    $initial = strtoupper(substr(Auth::user()->username, 0, 1));
                    $gradients = [
                        'linear-gradient(135deg, #FF9A9E 0%, #FAD0C4 100%)',
                        'linear-gradient(135deg, #A18CD1 0%, #FBC2EB 100%)',
                        'linear-gradient(135deg, #84FAB0 0%, #8FD3F4 100%)',
                        'linear-gradient(135deg, #FFDEE9 0%, #B5FFFC 100%)',
                        'linear-gradient(135deg, #C9FFBF 0%, #FFAFBD 100%)',
                    ];
                    $hash = crc32(Auth::user()->username);
                    $index = $hash % count($gradients);
                    $gradient = $gradients[$index];
                @endphp

                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link p-0" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            @if (Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="rounded-circle" width="40"
                                    height="40" style="object-fit: cover;">
                            @else
                                <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold"
                                    style="width: 40px; height: 40px; background: {{ $gradient }};">
                                    {{ $initial }}
                                </div>
                            @endif
                        </a>

                        <ul class="dropdown-menu dropdown-menu-end shadow border-0 mt-2"
                            style="min-width: 240px; border-radius: 12px;">
                            <!-- Header -->
                            <li class="px-3 pt-3 pb-2">
                                <div class="d-flex align-items-center">
                                    @if (Auth::user()->avatar)
                                        <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="rounded-circle me-3"
                                            width="45" height="45" style="object-fit: cover;">
                                    @else
                                        <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold me-3"
                                            style="width: 45px; height: 45px; background: {{ $gradient }};">
                                            {{ $initial }}
                                        </div>
                                    @endif
                                    <div>
                                        <div class="fw-semibold">{{ Auth::user()->username }}</div>
                                        <div class="text-muted small">{{ Auth::user()->email }}</div>
                                    </div>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>

                            @if (Auth::user()->role === 'admin')
                                <li>
                                    <a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}">
                                        <i class="ph ph-gauge me-2"></i> Dashboard
                                    </a>
                                </li>
                            @endif

                            <li><a class="dropdown-item py-2" href="#"><i class="ph ph-gear me-2"></i> Pengaturan
                                    Profil</a></li>
                            <li><a class="dropdown-item py-2" href="#"><i class="ph ph-question me-2"></i> Pusat
                                    Bantuan</a></li>
                            <li><a class="dropdown-item py-2" href="#"><i class="ph ph-moon me-2"></i> Mode Gelap</a>
                            </li>
                            <li><a class="dropdown-item py-2" href="#"><i class="ph ph-arrow-up-right me-2"></i>
                                    Upgrade Paket</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button class="dropdown-item text-danger py-2" type="submit">
                                        <i class="ph ph-sign-out me-2"></i> Sign Out
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            @else
                <!-- Tombol Login -->
                <a class="btn border-dark loginButton fw-bold ms-3 px-4 py-2" href="{{ route('login') }}">
                    Masuk / Daftar
                </a>
            @endauth
        </div>
    </div>
</nav>
