<nav class="navbar navbar-expand-lg py-3 border-bottom sticky-top" style="background: #fff">
    <div class="container">
        <!-- Logo -->
        <div class="logo">
            <span class="book fs-1">Book</span><span class="sphere fs-2">Sphere</span><span class="dot">.</span>
        </div>

        <!-- Hamburger for mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar items -->
        <div class="collapse navbar-collapse justify-content-end" id="navbarMain">
            <ul class="navbar-nav mb-2 mb-lg-0 align-items-center">

                <li class="nav-item"><a class="nav-link px-3" href="#">Beranda</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#">Layanan</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#">Katalog</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#">Kategori</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#">Tentang Kami</a></li>
                <li class="nav-item"><a class="nav-link px-3" href="#">Blog</a></li>
                <!-- Call to action Button -->
                <li class="nav-item">
                    <a class="btn border-dark mainButton rounded-pill fw-bold ms-3 px-4 py-2" href="{{ route('login') }}">Mulai Sekarang</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
