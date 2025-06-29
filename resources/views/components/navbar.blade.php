@php
    $isAdminPage = Request::is('admin*');
@endphp

<nav class="navbar navbar-expand-lg py-3 border-bottom fixed-top d-flex align-items-center justify-content-between"
    style="background: #fff">
    <div class="container-fluid d-flex align-items-center justify-content-between gap-3">

        {{-- === Brand === --}}
        <div class="d-flex align-items-center flex-shrink-0">
            <a href="{{ route('homepage') }}" class="text-decoration-none">
                <div class="logo">
                    <span class="book fs-1">Book</span><span class="sphere fs-2">Sphere</span><span class="dot">.</span>
                </div>
            </a>
        </div>

        {{-- === Navigation === --}}
        <div class="d-flex align-items-center flex-grow-1 justify-content-start ms-3 pt-2">
            <ul class="navbar-nav flex-row gap-5 align-items-center ms-3 mb-0">
                <li class="nav-item"><a
                        class="nav-link px-2 {{ Request::is('homepage') ? 'active fw-semibold text-primary-custom' : '' }}"
                        href="{{ route('homepage') }}">Beranda</a></li>
                @if (!$isAdminPage)
                    <li class="nav-item"><a
                            class="nav-link px-2 {{ Request::is('books/popular*') ? 'active fw-semibold text-primary-custom' : '' }}"
                            href="{{ route('user.books.popular') }}">Populer</a></li>
                    <li class="nav-item"><a
                            class="nav-link px-2 {{ Request::is('books') ? 'active fw-semibold text-primary-custom' : '' }}"
                            href="{{ route('user.books.index') }}">Katalog</a></li>
                    <li class="nav-item"><a
                            class="nav-link px-2 {{ Request::is('category') ? 'active fw-semibold text-primary-custom' : '' }}"
                            href="{{ route('user.category.index') }}">Kategori</a></li>
                    <li class="nav-item"><a class="nav-link px-2 scroll-link" href="#tentang"
                            data-target="tentang">Tentang</a></li>
                @endif
            </ul>
        </div>

        {{-- === Search Bar === --}}
        @if (!$isAdminPage)
            <form class="d-flex align-items-center position-relative mx-3 flex-grow-1" style="max-width: 600px;"
                id="searchForm" role="search">
                <input type="search" id="searchInput" placeholder="Search ..." aria-label="Search"
                    class="form-control border"
                    style="width: 100%; padding: 12px 60px 12px 20px; border-radius: 999px; border: none; font-size: 1rem; background-color: white; color: #333; height: 42px;">
                <button type="submit" class="position-absolute top-50 end-0 translate-middle-y border-0"
                    style="width: 42px; height: 42px; margin-right: 10px; border-radius: 50%; background:  #5D4037; display: flex; align-items: center; justify-content: center;">
                    <i class="ph ph-magnifying-glass text-white"></i>
                </button>
            </form>
        @endif

        {{-- === Cart + Profile / Login === --}}
        <div class="d-flex align-items-center gap-3 flex-shrink-0">
            @if (!$isAdminPage)
                <a href="#" id="cartBtn" class="rounded-circle shadow-sm me-3 text-white"
                    style="width: 42px; height: 42px; display: flex; align-items: center; justify-content: center; background: #5D4037;">
                    <i class="ph ph-shopping-cart"></i>
                </a>
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

                <div class="dropdown">
                    <a class="nav-link p-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
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
                            <li><a class="dropdown-item py-2" href="{{ route('admin.dashboard') }}"><i
                                        class="ph ph-gauge me-2"></i> Dashboard</a></li>
                        @endif
                        <li><a class="dropdown-item py-2" href="{{ route('user.collection') }}"><i
                                    class="ph ph-question me-2"></i> Koleksi Buku</a></li>
                        <li><a class="dropdown-item py-2" href="#"><i class="ph ph-gear me-2"></i> Pengaturan
                                Profil</a></li>
                        <li><a class="dropdown-item py-2" href="#"><i class="ph ph-moon me-2"></i> Mode Gelap</a></li>
                        <li><a class="dropdown-item py-2" href="#"><i class="ph ph-arrow-up-right me-2"></i> Upgrade
                                Paket</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button class="dropdown-item text-danger py-2" type="submit">
                                    <i class="ph ph-sign-out me-2"></i> Sign Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            @else
                <a class="btn border-dark loginButton fw-bold px-4 py-2" href="{{ route('login') }}">Masuk / Daftar</a>
            @endauth
        </div>
    </div>
</nav>

<div id="cartOverlay" class="position-fixed top-0 start-0 w-100 h-100"
    style="z-index: 1040; display: none; background-color: rgba(0, 0, 0, .5)"></div>
<div id="cartSidebar" class="cart-sidebar shadow-lg">
    <div
        class="cart-header shadow-sm d-flex justify-content-between align-items-center px-4 py-3 border-bottom bg-white">
        <div class="d-flex align-items-center gap-2">
            <i class="ph ph-shopping-cart text-primary-custom fs-4"></i>
            <h5 class="mb-0 fw-bold text-primary-custom">Keranjang Buku</h5>
        </div>
        <button id="closeCart" class="btn-close" aria-label="Close"></button>
    </div>

    <div class="cart-body px-4 py-3">

    </div>

    <div class="cart-footer border-top px-4 py-3 bg-white" style="box-shadow: 0 -4px 12px rgba(0, 0, 0, 0.15);">
        <a href="{{ route('cart.verify') }}" class="btn w-100 text-white rounded-pill fw-semibold"
            style="background: linear-gradient(to right, #5D4037, #8d7b7b)">
            Pinjam Buku
        </a>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const cartSidebar = document.getElementById('cartSidebar');
        const cartBtn = document.getElementById('cartBtn');
        const closeBtn = document.getElementById('closeCart');
        const cartOverlay = document.getElementById('cartOverlay');

        function openCart() {
            fetch('/cart/view')
                .then(res => res.json())
                .then(data => {
                    document.querySelector('.cart-body').innerHTML = data.html;
                    cartSidebar.classList.add('show');
                    cartOverlay.style.display = 'block';
                    document.body.style.overflow = 'hidden';
                });
        }

        function closeCart() {
            cartSidebar.classList.remove('show');
            cartOverlay.style.display = 'none';
            document.body.style.overflow = '';
        }

        cartBtn.addEventListener('click', function(e) {
            e.preventDefault();
            openCart();
        });

        closeBtn.addEventListener('click', closeCart);
        cartOverlay.addEventListener('click', closeCart);
        cartSidebar.addEventListener('click', function(e) {
            e.stopPropagation();
        });
    });
</script>
