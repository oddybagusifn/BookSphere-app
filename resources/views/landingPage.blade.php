@extends('layouts.app')

<x-navLandingPage></x-navLandingPage>


@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center ">
                <div class="col-md-6">
                    <h1 class="fw-bold">Menjelajahi Dunia Buku untuk Sukses Masa Depan</h1>
                    <p>BookSphere membantu Anda menemukan, meminjam, dan membaca buku digital dengan mudah dan cepat kapan
                        saja.</p>
                    <a href="#" class="btn btn-light fw-bold px-4 text-light py-2 rounded-pill"
                        style="background-color: #5D4037">Jelajahi Koleksi</a>
                </div>
                <div class="col-md-6 hero-image text-center mt-4 mt-md-0">
                    <img class="img-fluid" src="{{ asset('img/illustration.png') }}" alt="Ilustrasi BookSphere">
                </div>
            </div>
        </div>
    </section>

    <section class="py-4">
        <div class="container d-flex flex-wrap justify-content-evenly align-items-center gap-4 my-4">
            <img src="https://upload.wikimedia.org/wikipedia/commons/4/45/Gramedia_wordmark.svg" width="150"
                alt="Gramedia">
            <img src="{{ asset('img/google-book.svg') }}" width="150" alt="Google Books">
            <img src="{{ asset('img/elsevier.png') }}" width="150" alt="Elsevier">
            <img src="{{ asset('img/Springer.svg') }}" width="150" alt="Springer">
        </div>


    </section>

    <!-- Services Section -->
    <section class="py-5">
        <div class="container">
            <div class="d-flex align-items-center gap-5 w-75 py-5 my-5">
                <h2 class="fw-bold mb-3 text-accent">Layanan</h2>
                <p class="fw-light fs-6">
                    BookSphere menyediakan beragam layanan untuk mempermudah Anda dalam menemukan, meminjam, dan menikmati
                    berbagai koleksi buku digital. Semua layanan dirancang untuk memberikan pengalaman membaca yang nyaman
                    dan efisien.
                </p>
            </div>

            <div class="row g-4">
                <!-- Service 1 -->
                <div class="col-md-6">
                    <div class="card card-light rounded-4 mb-4 shadow-sm p-3">
                        <div class="card-body d-flex">
                            <div class="w-50">
                                <h5 class="card-title fs-4 fw-semibold text-accent w-75 py-2">Pencarian Buku</h5>
                                <p class="card-text pt-3">Temukan buku favorit Anda dengan fitur pencarian pintar yang cepat
                                    dan akurat.</p>
                            </div>
                            <div class="w-50 d-flex justify-content-center align-items-center">
                                <i class="ph ph-magnifying-glass ph-light" style="color: #5D4037; font-size: 120px;"></i>
                            </div>
                        </div>
                        <div class="card-footer border-0 bg-transparent py-4">
                            <a href="#" class="card-link text-accent">Pelajari lebih lanjut →</a>
                        </div>
                    </div>
                </div>

                <!-- Service 2 -->
                <div class="col-md-6">
                    <div class="card card-accent rounded-4 mb-4 shadow-sm p-3 card-custom">
                        <div class="card-body d-flex">
                            <div class="w-50">
                                <h5 class="card-title fs-4 fw-semibold  w-75 py-2">Pinjam Buku Online</h5>
                                <p class="card-text pt-3">Pinjam buku kapan saja secara online tanpa harus datang ke
                                    perpustakaan fisik.</p>
                            </div>
                            <div class="w-50 d-flex justify-content-center align-items-center">
                                <i class="ph ph-book ph-light" style="font-size: 120px;"></i>
                            </div>
                        </div>
                        <div class="card-footer border-0 bg-transparent py-4">
                            <a href="#" class="card-link text-light">Pelajari lebih lanjut →</a>
                        </div>
                    </div>
                </div>

                <!-- Service 3 -->
                <div class="col-md-6">
                    <div class="card card-accent rounded-4 mb-4 shadow-sm p-3">
                        <div class="card-body d-flex">
                            <div class="w-50">
                                <h5 class="card-title fs-4 fw-semibold w-75 py-2">Komunitas Pembaca</h5>
                                <p class="card-text pt-3">Bergabung dengan komunitas untuk berdiskusi dan berbagi
                                    rekomendasi buku favorit.</p>
                            </div>
                            <div class="w-50 d-flex justify-content-center align-items-center">
                                <i class="ph ph-users ph-light" style="font-size: 120px;"></i>
                            </div>
                        </div>
                        <div class="card-footer border-0 bg-transparent py-4">
                            <a href="#" class="card-link text-light">Pelajari lebih lanjut →</a>
                        </div>
                    </div>
                </div>

                <!-- Service 4 -->
                <div class="col-md-6">
                    <div class="card card-light rounded-4 mb-4 shadow-sm p-3">
                        <div class="card-body d-flex">
                            <div class="w-50">
                                <h5 class="card-title fs-4 fw-semibold text-accent w-75 py-2">E-Book Reader</h5>
                                <p class="card-text pt-3">Nikmati pengalaman membaca langsung dari browser atau aplikasi
                                    kami tanpa instalasi tambahan.</p>
                            </div>
                            <div class="w-50 d-flex justify-content-center align-items-center">
                                <i class="ph ph-device-mobile ph-light" style="color: #5D4037; font-size: 120px;"></i>
                            </div>
                        </div>
                        <div class="card-footer border-0 bg-transparent py-4">
                            <a href="#" class="card-link text-accent">Pelajari lebih lanjut →</a>
                        </div>
                    </div>
                </div>

                <!-- Service 5 -->
                <div class="col-md-6">
                    <div class="card card-light rounded-4 mb-4 shadow-sm p-3">
                        <div class="card-body d-flex">
                            <div class="w-50">
                                <h5 class="card-title fs-4 fw-semibold text-accent w-75 py-2">Riwayat Peminjaman</h5>
                                <p class="card-text pt-3">Lihat catatan lengkap buku yang pernah Anda pinjam dalam satu
                                    halaman khusus.</p>
                            </div>
                            <div class="w-50 d-flex justify-content-center align-items-center">
                                <i class="ph ph-clock ph-light" style="color: #5D4037; font-size: 120px;"></i>
                            </div>
                        </div>
                        <div class="card-footer border-0 bg-transparent py-4">
                            <a href="#" class="card-link text-accent">Pelajari lebih lanjut →</a>
                        </div>
                    </div>
                </div>

                <!-- Service 6 -->
                <div class="col-md-6">
                    <div class="card card-accent rounded-4 mb-4 shadow-sm p-3">
                        <div class="card-body d-flex">
                            <div class="w-50">
                                <h5 class="card-title fs-4 fw-semibold  w-75 py-2">Statistik Membaca</h5>
                                <p class="card-text pt-3">Pantau progres membaca Anda, mulai dari jumlah buku hingga
                                    kategori favorit.</p>
                            </div>
                            <div class="w-50 d-flex justify-content-center align-items-center">
                                <i class="ph ph-chart-bar ph-light" style=" font-size: 120px;"></i>
                            </div>
                        </div>
                        <div class="card-footer border-0 bg-transparent py-4">
                            <a href="#" class="card-link text-light">Pelajari lebih lanjut →</a>
                        </div>
                    </div>
                </div>
            </div>
    </section>

    <section class="py-5">
        <div class="container">
            <h2 class="fw-bold mb-4 text-accent">Proses Peminjaman Buku</h2>

            <div class="accordion d-flex flex-column gap-3">

                <!-- Step 1 -->
                <div class="step">
                    <div class="step-header d-flex justify-content-between align-items-center" data-bs-target="#step1">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fw-bold fs-4">01</span>
                            <span class="fw-semibold">Login ke Akun Anda</span>
                        </div>
                        <i class="ph ph-plus-circle toggle-icon"></i>
                    </div>
                    <div class="step-body" id="step1">
                        <div class="card-body border-0">
                            Silakan login ke akun BookSphere Anda untuk mulai meminjam buku dan mengakses fitur-fitur
                            lainnya.
                        </div>
                    </div>
                </div>

                <!-- Step 2 -->
                <div class="step">
                    <div class="step-header d-flex justify-content-between align-items-center" data-bs-target="#step2">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fw-bold fs-4">02</span>
                            <span class="fw-semibold">Cari Buku yang Diinginkan</span>
                        </div>
                        <i class="ph ph-plus-circle toggle-icon"></i>
                    </div>
                    <div class="step-body" id="step2">
                        <div class="card-body border-0">
                            Gunakan fitur pencarian untuk menemukan buku favorit Anda berdasarkan judul, penulis, atau
                            kategori.
                        </div>
                    </div>
                </div>

                <!-- Step 3 -->
                <div class="step">
                    <div class="step-header d-flex justify-content-between align-items-center" data-bs-target="#step3">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fw-bold fs-4">03</span>
                            <span class="fw-semibold">Pilih dan Tambahkan ke Keranjang</span>
                        </div>
                        <i class="ph ph-plus-circle toggle-icon"></i>
                    </div>
                    <div class="step-body" id="step3">
                        <div class="card-body border-0">
                            Setelah menemukan buku, klik tombol "Pinjam" atau "Tambahkan ke Keranjang" untuk melanjutkan
                            proses.
                        </div>
                    </div>
                </div>

                <!-- Step 4 -->
                <div class="step">
                    <div class="step-header d-flex justify-content-between align-items-center" data-bs-target="#step4">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fw-bold fs-4">04</span>
                            <span class="fw-semibold">Konfirmasi Peminjaman</span>
                        </div>
                        <i class="ph ph-plus-circle toggle-icon"></i>
                    </div>
                    <div class="step-body" id="step4">
                        <div class="card-body border-0">
                            Periksa kembali daftar buku di keranjang Anda, lalu klik "Konfirmasi Peminjaman" untuk
                            menyelesaikan.
                        </div>
                    </div>
                </div>

                <!-- Step 5 -->
                <div class="step">
                    <div class="step-header d-flex justify-content-between align-items-center" data-bs-target="#step5">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fw-bold fs-4">05</span>
                            <span class="fw-semibold">Nikmati Buku Anda</span>
                        </div>
                        <i class="ph ph-plus-circle toggle-icon"></i>
                    </div>
                    <div class="step-body" id="step5">
                        <div class="card-body border-0">
                            Buku sudah tersedia di akun Anda dan dapat mulai dibaca melalui fitur E-Book Reader kami.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <!-- Apa itu BookSphere -->
    <section class="py-5">
        <div class="container text-center">
            <h2 class="fw-bold display-5 text-accent mb-5">Apa itu BookSphere?</h2>

            <div class="row justify-content-center g-4">

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                        <div class="mb-3">
                            <i class="ph ph-books ph-bold" style="font-size: 60px; color: #5D4037;"></i>
                        </div>
                        <h5 class="fw-semibold mb-2">Perpustakaan Digital</h5>
                        <p class="fw-light small">
                            Akses ribuan buku dari berbagai kategori hanya dalam beberapa klik—kapan saja, di mana saja.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                        <div class="mb-3">
                            <i class="ph ph-globe-hemisphere-west ph-bold" style="font-size: 60px; color: #5D4037;"></i>
                        </div>
                        <h5 class="fw-semibold mb-2">Akses Fleksibel</h5>
                        <p class="fw-light small">
                            BookSphere dapat digunakan langsung melalui browser atau aplikasi tanpa instalasi tambahan.
                        </p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 p-4">
                        <div class="mb-3">
                            <i class="ph ph-user-focus ph-bold" style="font-size: 60px; color: #5D4037;"></i>
                        </div>
                        <h5 class="fw-semibold mb-2">Pengalaman Personal</h5>
                        <p class="fw-light small">
                            Dapatkan rekomendasi, statistik membaca, dan fitur interaktif yang disesuaikan dengan preferensi
                            Anda.
                        </p>
                    </div>
                </div>

            </div>

            <div class="row justify-content-center mt-5">
                <div class="col-md-10 col-lg-8">
                    <p class="fs-6 fw-light mb-4">
                        <strong>BookSphere</strong> bukan sekadar perpustakaan digital, tapi sebuah ekosistem membaca modern
                        yang menggabungkan teknologi dan literasi.
                        Kami berkomitmen untuk menjadikan membaca sebagai bagian dari gaya hidup generasi masa kini.
                    </p>
                </div>
            </div>

            <h3 class="fw-semibold text-accent mt-5">Mulailah perjalanan literasi Anda bersama BookSphere.</h3>
        </div>
    </section>
@endsection
