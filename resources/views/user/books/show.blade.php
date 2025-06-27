@extends('layouts.app')

@section('content')
    <div class="container-fluid py-5">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('homepage') }}">Homepage</a></li>
                <li class="breadcrumb-item"><a href="{{ route('user.books.index') }}">Buku</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $book->title }}</li>
            </ol>
        </nav>

        <div class="row g-5 align-items-start">
            {{-- Left: Book Cover --}}
            <div class="col-md-5">
                <div class="position-relative rounded-4 shadow-sm overflow-hidden p-5 d-flex align-items-center justify-content-center"
                    style="height: 460px; background-size: cover; background-position: center; background-image: url('{{ $book->cover_url }}');">

                    {{-- Overlay Blur dan Fade Hitam --}}
                    <div class="position-absolute top-0 start-0 w-100 h-100"
                        style="
                backdrop-filter: blur(6px);
                background: radial-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8));
                z-index: 1;
            ">
                    </div>

                    {{-- Gambar utama --}}
                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="img-fluid h-100 position-relative"
                        style="object-fit: contain; z-index: 2; box-shadow: 0 4px 18px rgba(0, 0, 0, 0.5);">
                </div>
            </div>


            {{-- Right: Book Info --}}
            <div class="col-md-7">
                <h3 class="fw-bold text-dark mb-2">{{ $book->title }}</h3>
                <p class="text-muted mb-2">Oleh <strong>{{ $book->author }}</strong></p>
                <p class="text-muted mb-3">
                    Ditambahkan {{ $book->created_at->diffForHumans() }}
                    &nbsp;|&nbsp;
                    <strong>Kategori:</strong>
                    <span class="badge rounded-pill border border-dark text-dark px-3 py-1">
                        {{ $book->category->name ?? 'Umum' }}
                    </span>
                </p>

                <div class="d-flex flex-wrap gap-4 text-muted small mb-3 mt-3">
                    @if ($book->isbn)
                        <div><strong>ISBN:</strong> {{ $book->isbn }}</div>
                    @endif
                    @if ($book->published_year)
                        <div><strong>Tahun Terbit:</strong> {{ $book->published_year }}</div>
                    @endif
                    @if ($book->page_count)
                        <div><strong>Jumlah Halaman:</strong> {{ $book->page_count }}</div>
                    @endif
                </div>

                {{-- Sinopsis --}}
                <div class="mb-4 ">
                    <h6 class="fw-semibold">Sinopsis</h6>
                    <p class="text-muted">
                        {{ $book->synopsis ?? 'Tidak ada sinopsis untuk buku ini.' }}
                    </p>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex gap-3  ">
                    <form action="{{ route('user.books.borrow', $book->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn text-white fw-semibold rounded-pill px-4 py-2"
                            style="background-color: #5D4037;">
                            <i class="ph ph-book-open me-1"></i> Baca Sekarang
                        </button>
                    </form>
                </div>
            </div>
        </div>


        {{-- ==== Rating dan Ulasan ==== --}}
        <div class="pt-5 mt-5 mb-5 border-top">
            <h4 class="text-accent fw-bold mb-3"><i class="ph ph-star me-2"></i> Ulasan Pembaca</h4>
            <p class="text-muted mb-4">Pendapat para peminjam setelah membaca buku ini.</p>
            <div class="row g-4">
                <!-- Kiri: Ringkasan & Filter -->
                <div class="col-lg-4">
                    <div class="border rounded-4 p-4">
                        <!-- Skor Utama -->
                        <div class="d-flex flex-column align-items-center mb-4">
                            <div class="rounded-circle d-flex align-items-center justify-content-center mb-2"
                                style="width: 80px; height: 80px; border: 3px solid #5D4037; color: #5D4037; font-size: 24px; font-weight: bold;">
                                {{ number_format($averageRating, 1) }}
                            </div>
                            <div class="text-warning mb-1">
                                @for ($i = 1; $i <= $averageRating; $i++)
                                    <i
                                        class="ph {{ $i <= round($averageRating) ? 'ph-star' : 'ph-star' }}"></i>
                                @endfor
                            </div>
                            <small class="text-muted">from {{ number_format($totalReviews) }} reviews</small>
                        </div>

                        <!-- Distribusi Rating -->
                        @foreach (range(5, 1) as $star)
                            <div class="d-flex align-items-center mb-2">
                                <div style="width: 40px;" class="text-muted small">{{ $star }} <i
                                        class="ph ph-star-fill text-warning"></i></div>
                                <div class="progress flex-grow-1 bg-light" style="height: 6px;">
                                    <div class="progress-bar"
                                        style="width: {{ $reviewDistribution[$star] ?? 0 }}%; background-color: #5D4037;">
                                    </div>
                                </div>
                                <div style="width: 40px; text-align: right;" class="text-muted small ms-2">
                                    {{ $reviewCounts[$star] ?? 0 }}</div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Filter Rating & Topik -->
                    <div class="border rounded-4 p-4 mt-4">
                        <h6 class="fw-bold mb-3">Reviews Filter</h6>
                        <p class="small fw-semibold mb-1">Rating</p>
                        @foreach (range(5, 1) as $star)
                            <div class="form-check mb-1">
                                <input class="form-check-input" type="checkbox" id="rate-{{ $star }}">
                                <label class="form-check-label small"
                                    for="rate-{{ $star }}">{{ $star }}</label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Kanan: Review Tabs & List -->
                <div class="col-lg-8">
                    <!-- Tabs -->
                    <div class="d-flex gap-2 mb-3">
                        <button class="btn btn-outline-dark rounded-pill px-3 py-1">All Reviews</button>
                    </div>

                    <!-- Review List -->
                    <div class="d-flex flex-column gap-4">
                        @forelse ($book->reviews as $review)
                            <div class="border rounded-4 p-4 bg-white">
                                <!-- Rating -->
                                <div class="text-warning mb-2">
                                    @for ($i = 1; $i <= $review->rating; $i++)
                                        <i class="ph {{ $i <= $review->rating ? 'ph-star' : 'ph-star' }}"></i>
                                    @endfor
                                </div>

                                <!-- Komentar -->
                                <p class="fw-semibold mb-1">
                                    {{ $review->comment ?: 'This user did not leave a comment.' }}
                                </p>
                                <p class="text-muted small mb-3">
                                    {{ $review->created_at->format('F j, Y h:i A') }}
                                </p>

                                <!-- User & Reaksi -->
                                <div class="d-flex justify-content-between align-items-center border-top pt-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="{{ $review->user->avatar ?? asset('default-avatar.png') }}"
                                            class="rounded-circle" width="32" height="32" alt="Avatar">
                                        <span class="fw-semibold">{{ $review->user->username }}</span>
                                    </div>
                                    <div class="d-flex align-items-center gap-2">
                                        <button class="btn btn-sm border rounded-pill d-flex align-items-center gap-1 px-3">
                                            <i class="ph ph-thumbs-up-fill"></i> {{ rand(0, 200) }}
                                        </button>
                                        <button class="btn btn-sm border rounded-pill d-flex align-items-center gap-1 px-3">
                                            <i class="ph ph-thumbs-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted">No reviews available.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>




        {{-- ==== Rekomendasi Buku ==== --}}
        @if ($relatedBooks->count() > 0)
            <div class="pt-5 mt-5 mb-5">
                <h4 class="text-accent fw-bold mb-3"><i class="ph ph-books me-2"></i> Rekomendasi Buku</h4>
                <p class="text-muted mb-4">Koleksi buku lain yang mungkin kamu sukai berdasarkan kategori yang sama.</p>

                <div class="row g-3">
                    @foreach ($relatedBooks as $index => $book)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card border-0 rounded-4 h-100 d-flex flex-column overflow-hidden bg-white p-4"
                                style="box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">

                                {{-- Gambar Buku --}}
                                <div class="d-flex justify-content-center align-items-center mb-4" style="height: 220px;">
                                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="rounded"
                                        style="max-height: 100%; max-width: 100%; object-fit: contain;box-shadow: 0 4px 18px rgba(0, 0, 0, 0.5);">
                                </div>

                                {{-- Nomor & Judul --}}
                                <div class="mb-1 text-muted small" style="letter-spacing: 0.05em;">
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}.
                                </div>
                                <h5 class="fw-bold text-dark mb-2">{{ $book->title }}</h5>

                                {{-- ISBN & Tahun Terbit --}}
                                <div class="d-flex justify-content-between text-muted small mb-2"
                                    style="font-size: 0.85rem;">
                                    @if ($book->isbn)
                                        <span><strong>ISBN:</strong> {{ $book->isbn }}</span>
                                    @endif
                                    @if ($book->published_year)
                                        <span><strong>Terbit:</strong> {{ $book->published_year }}</span>
                                    @endif
                                </div>

                                <hr class="my-2">

                                {{-- Deskripsi Singkat --}}
                                <p class="text-muted small flex-grow-1">
                                    {{ Str::limit(strip_tags($book->synopsis ?? 'Buku ini dapat dibaca langsung di perpustakaan digital.'), 100) }}
                                </p>

                                {{-- Kategori --}}
                                <p class="fw-semibold text-dark mb-1 mt-auto">Kategori</p>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <span class="badge border border-dark text-dark rounded-pill px-3 py-1 small">
                                        {{ $book->category->name ?? 'Umum' }}
                                    </span>
                                </div>

                                {{-- Tombol Aksi --}}
                                <div class="d-flex gap-2">
                                    <form action="{{ route('user.books.borrow', $book->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn text-white fw-semibold rounded-pill px-3 py-1"
                                            style="background-color: #5D4037;">
                                            <i class="ph ph-book-open me-1"></i> Baca
                                        </button>
                                    </form>
                                    <a href="{{ route('user.books.show', $book->id) }}"
                                        class="btn btn-outline-dark fw-medium rounded-pill px-3 py-1">
                                        <i class="ph ph-info me-1"></i> Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
