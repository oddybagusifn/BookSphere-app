@extends('layouts.app')

@section('content')
    <div class="container-fluid py-5">

        <div id="bookCarousel" class="carousel slide mb-5" data-bs-ride="carousel">
            <div class="carousel-inner rounded-4 shadow overflow-hidden">
                @foreach ($carouselBooks as $index => $book)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        <div class="d-flex flex-wrap align-items-center position-relative" style="min-height: 600px;">

                            {{-- Background blur --}}
                            <div class="position-absolute top-0 start-0 w-100 h-100 z-n1"
                                style="background-image: url('{{ $book->cover_url }}');
                               background-size: cover;
                               background-position: center;
                               filter: blur(10px) brightness(0.5);">
                            </div>


                            {{-- Gradasi sisi kiri --}}
                            <div class="position-absolute top-0 start-0 w-100 h-100 z-0"
                                style="background: linear-gradient(to right, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 30%, rgba(0,0,0,0.6) 60%);">
                            </div>

                            {{-- Gambar besar di kiri --}}
                            <div class="col-md-6 d-flex align-items-center justify-content-center"
                                style="min-height: 600px;">
                                <img src="{{ $book->cover_url }}" alt="{{ $book->title }}"
                                    class="img-fluid rounded-4 shadow w-25" style="max-height: 90%;">
                            </div>

                            {{-- Informasi di kanan --}}
                            <div class="col-md-6 px-5 text-white position-relative">
                                <h1 class="fw-bold display-5 mb-2">{{ $book->title }}</h1>
                                <p class="lead mb-1">{{ $book->author }}</p>
                                <p class="mb-2">Kategori:
                                    <span class="text-white-50">{{ $book->category->name ?? 'Tanpa Kategori' }}</span>
                                </p>
                                <p class="mb-4">ISBN:
                                    <span class="text-white-50">{{ $book->isbn ?? 'Tidak tersedia' }}</span>
                                </p>

                                <ul class="list-unstyled mb-4">
                                    <li class="mb-1">
                                        <span class="fs-3"><i class="ph ph-book-open"></i></span>
                                        <strong class="ms-2">{{ $book->page_count ?? '??' }} halaman</strong>
                                        <span class="ms-2 text-white-50">total halaman buku ini</span>
                                    </li>
                                    <li class="mb-3">
                                        <span class="fs-3"><i class="ph ph-calendar-blank"></i></span>
                                        <strong class="ms-2">{{ $book->published_year ?? '????' }}</strong>
                                        <span class="ms-2 text-white-50">tahun terbit</span>
                                    </li>
                                </ul>

                                <a href="{{ route('user.books.show', $book->id) }}"
                                    class="btn btn-outline-light fw-semibold rounded-pill px-4 py-2 text-uppercase">
                                    <i class="ph ph-arrow-right me-1"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Navigasi --}}
            <button class="carousel-control-prev" type="button" data-bs-target="#bookCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bookCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>



        {{-- ==== BUKU TERPOPULER ==== --}}
        <div class="pt-5 mb-5">
            <h4 class="text-accent fw-bold mb-3"><i class="ph ph-fire me-2"></i> Buku Terpopuler</h4>
            <p class="text-muted mb-4">Buku-buku yang paling banyak diminati dan dipinjam oleh pengguna kami akhir-akhir
                ini.</p>

            @php
                $firstBook = $popularBooks->get(0);
                $secondBook = $popularBooks->get(1);
                $thirdBook = $popularBooks->get(2);
            @endphp

            @if ($firstBook && $secondBook && $thirdBook)
                <div class="row g-4">
                    {{-- Kiri - buku besar --}}
                    <div class="col-12 col-lg-4">
                        <a href="{{ route('user.books.show', $firstBook->id) }}" class="text-decoration-none text-white">
                            <div class="position-relative rounded-4 overflow-hidden shadow" style="height: 580px;">
                                <img src="{{ $firstBook->cover_url }}" class="w-100 h-100 position-absolute top-0 start-0"
                                    style="object-fit: cover; z-index: 1;">
                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                    style="background: linear-gradient(to top, rgba(0,0,0,0.7), rgba(0,0,0,0)); z-index: 2;">
                                </div>
                                <div class="position-absolute bottom-0 start-0 w-100 p-4 d-flex flex-column justify-content-end"
                                    style="z-index: 3;">
                                    <div class="d-flex align-items-center mb-2">
                                        <img src="https://i.pravatar.cc/36?u={{ $firstBook->author }}"
                                            alt="{{ $firstBook->author }}" class="rounded-circle me-2" width="36"
                                            height="36">
                                        <span class="text-light small">{{ $firstBook->author }}</span>
                                    </div>
                                    <h4 class="fw-bold mb-1 text-white">{{ $firstBook->title }}</h4>
                                    <small class="text-white-50 d-block mb-1">Kategori:
                                        {{ $firstBook->category->name ?? '-' }}</small>
                                    <small class="text-white-50">
                                        @if ($firstBook->isbn)
                                            <strong>ISBN:</strong> {{ $firstBook->isbn }}
                                        @endif
                                        @if ($firstBook->published_year)
                                            <span class="ms-2"><strong>Terbit:</strong>
                                                {{ $firstBook->published_year }}</span>
                                        @endif
                                    </small>
                                </div>
                            </div>
                        </a>
                    </div>

                    {{-- Kanan - 2 buku kecil --}}
                    <div class="col-12 col-lg-4 d-flex flex-column gap-4">
                        @foreach ([$secondBook, $thirdBook] as $book)
                            <a href="{{ route('user.books.show', $book->id) }}"
                                class="text-decoration-none text-white flex-grow-1">
                                <div class="position-relative rounded-4 overflow-hidden shadow" style="height: 280px;">
                                    <img src="{{ $book->cover_url }}" class="w-100 h-100 position-absolute top-0 start-0"
                                        style="object-fit: cover; z-index: 1;">
                                    <div class="position-absolute top-0 start-0 w-100 h-100"
                                        style="background: linear-gradient(to top, rgba(0,0,0,0.6), rgba(0,0,0,0)); z-index: 2;">
                                    </div>
                                    <div class="position-absolute bottom-0 start-0 w-100 p-3 d-flex flex-column justify-content-end"
                                        style="z-index: 3;">
                                        <div class="d-flex align-items-center mb-1">
                                            <img src="https://i.pravatar.cc/32?u={{ $book->author }}"
                                                alt="{{ $book->author }}" class="rounded-circle me-2" width="32"
                                                height="32">
                                            <span class="text-light small">{{ $book->author }}</span>
                                        </div>
                                        <h6 class="fw-bold mb-1 text-white">{{ $book->title }}</h6>
                                        <small class="text-white-50 d-block">Kategori:
                                            {{ $book->category->name ?? '-' }}</small>
                                        <small class="text-white-50">
                                            @if ($book->isbn)
                                                <strong>ISBN:</strong> {{ $book->isbn }}
                                            @endif
                                            @if ($book->published_year)
                                                <span class="ms-2"><strong>Terbit</strong>
                                                    {{ $book->published_year }}</span>
                                            @endif
                                        </small>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    {{-- CTA --}}
                    <div class="col-12 col-lg-4 d-flex justify-content-center flex-column gap-4">
                        <div class="ms-5 ps-4 fs-5 d-flex align-items-center gap-4">
                            <div
                                class="d-flex align-items-center rounded-pill justify-content-center fw-semibold gap-3 py-2 px-4 border border-dark">
                                <a href="{{ route('user.books.popular') }}">Baca Sekarang</a>
                            </div>
                            <i class="ph ph-arrow-right fw-semibold"></i>
                        </div>
                        <p class="ms-5 ps-4 text-muted-25 small mb-2 w-75">
                            Ayo mulai membaca buku paling populer dan lihat kenapa semua orang menyukainya!
                        </p>
                    </div>
                </div>
            @else
                <p class="text-muted">Belum ada cukup data buku populer untuk ditampilkan.</p>
            @endif
        </div>


        <div class="pt-5 mb-5">
            <h4 class="text-accent fw-bold mb-3"><i class="ph ph-books me-2"></i> Buku Terbaru</h4>
            <p class="text-muted mb-4">Lihat koleksi terbaru yang baru saja ditambahkan ke perpustakaan digital kami.</p>

            <div class="row g-3" id="bookCards">
                @foreach ($newestBooks as $index => $book)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 book-card" data-title="{{ strtolower($book->title) }}"
                        data-author="{{ strtolower($book->author) }}" data-year="{{ $book->published_year }}"
                        data-category="{{ strtolower($book->category->name ?? 'umum') }}">
                        <div class="card border-0 rounded-4 h-100 d-flex flex-column overflow-hidden bg-white p-4"
                            style="box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">

                            <div class="position-relative overflow-hidden mb-4"
                                style="height: 220px; border-radius: 0.5rem;">
                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                    style="
            background: url('{{ $book->cover_url }}') center center / cover no-repeat;
            filter: blur(2px) brightness(0.6);
            z-index: 1;
        ">
                                </div>

                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                    style="
            z-index: 2;
            background: radial-gradient(rgba(0, 0, 0, 0) 30%, rgba(0, 0, 0, 0.4) 100%);
        ">
                                </div>

                                <div class="position-relative d-flex justify-content-center align-items-center h-100"
                                    style="z-index: 3;">
                                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="rounded shadow"
                                        style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                </div>
                            </div>

                            <div class="mb-1 d-flex justify-content-between  align-items-center">
                                <h5 class="fw-bold text-dark w-75">{{ $book->title }}</h5>
                                @php
                                    $averageRating = number_format($book->reviews->avg('rating') ?? 0, 1);
                                @endphp
                                <div class="d-flex align-items-center mb-2 fs-6 gap-1 text-warning small">
                                    <img src="{{ asset('img/star.svg') }}" alt="Rating" width="16" height="16">
                                    <span class="text-muted ms-1 ">({{ $averageRating }})</span>
                                </div>
                            </div>

                            <div class="d-flex justify-content-between text-muted small mb-2" style="font-size: 0.85rem;">
                                @if ($book->isbn)
                                    <span><strong>ISBN:</strong> {{ $book->isbn }}</span>
                                @endif
                                @if ($book->published_year)
                                    <span><strong>Terbit:</strong> {{ $book->published_year }}</span>
                                @endif
                            </div>

                            <hr class="my-2">

                            <p class="text-muted small flex-grow-1">
                                {{ Str::limit(strip_tags($book->synopsis ?? 'Buku ini dapat dibaca langsung di perpustakaan digital.'), 100) }}
                            </p>

                            <p class="fw-semibold text-dark mb-1 mt-auto">Kategori</p>
                            <div class="d-flex flex-wrap gap-2 mb-3">
                                <span class="badge border border-dark text-dark rounded-pill px-3 py-1 small">
                                    {{ $book->category->name ?? 'Umum' }}
                                </span>
                            </div>

                            <div class="gap-2 p-0 text-start">
                                <form action="{{ route('cart.add') }}" method="POST" class="d-inline-block mb-1">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
                                    <button type="submit" class="btn text-white fw-semibold rounded-pill px-3 py-1"
                                        style="background-color: #5D4037;">
                                        <i class="ph ph-book-open me-1"></i> Baca
                                    </button>
                                </form>

                                <a href="{{ route('user.books.show', $book->id) }}"
                                    class="btn btn-outline-dark fw-medium rounded-pill px-3 py-1 d-inline-block ms-1">
                                    <i class="ph ph-info me-1"></i> Detail
                                </a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>




        {{-- CTA LIHAT SEMUA BUKU --}}
        <div class="pt-5 text-center">
            <a href="{{ route('user.books.index') }}" class="btn  rounded-pill border-dark px-4 py-2">
                <i class="ph ph-books me-1"></i> Lihat Semua Buku
            </a>
        </div>

    </div>
@endsection
