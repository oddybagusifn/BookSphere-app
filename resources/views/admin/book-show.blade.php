@extends('layouts.app')

@section('content')
    <section class="py-5 px-3 px-md-5 min-vh-100">
        <div class="container">
            <div class="mb-5">
                <h2 class="fw-bold text-accent border-bottom pb-2 d-flex align-items-center">
                    <i class="ph ph-book-open me-2 fs-3"></i> Detail Buku
                </h2>
                <p class="text-muted">Informasi lengkap tentang buku yang tersedia.</p>
            </div>

            <div class="row g-5 align-items-start">
                <!-- Cover Buku -->
                <div class="col-md-5">
                    <div class="position-relative rounded-4 shadow-sm overflow-hidden p-5 d-flex align-items-center justify-content-center"
                        style="height: 460px; background-size: cover; background-position: center; background-image: url('{{ $book->cover_url }}');">

                        <div class="position-absolute top-0 start-0 w-100 h-100"
                            style="backdrop-filter: blur(6px); background: radial-gradient(rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8)); z-index: 1;">
                        </div>

                        <img src="{{ $book->cover_url }}" alt="{{ $book->title }}"
                            class="img-fluid h-100 position-relative"
                            style="object-fit: contain; z-index: 2; box-shadow: 0 4px 18px rgba(0, 0, 0, 0.5);">
                    </div>
                </div>

                <!-- Informasi Buku -->
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
                        @if ($book->edition)
                            <div><strong>Edisi:</strong> {{ $book->edition }}</div>
                        @endif
                        @if ($book->language)
                            <div><strong>Bahasa:</strong> {{ $book->language }}</div>
                        @endif
                        @if ($book->publisher)
                            <div><strong>Penerbit:</strong> {{ $book->publisher }}</div>
                        @endif
                    </div>

                    <div class="mb-4">
                        <h6 class="fw-semibold">Sinopsis</h6>
                        <p class="text-muted">{{ $book->synopsis ?? 'Tidak ada sinopsis untuk buku ini.' }}</p>
                    </div>

                    @if ($book->read_url && $book->is_readable)
                        <div class="mb-3">
                            <a href="{{ $book->read_url }}" target="_blank"
                                class="btn text-white fw-semibold rounded-pill px-4 py-2"
                                style="background-color: #5D4037;">
                                <i class="ph ph-book-open me-2"></i> Baca Buku
                            </a>
                        </div>
                    @endif

                    <div class="d-flex gap-3">
                        <a href="{{ route('admin.books') }}" class="btn text-white fw-semibold rounded-pill px-4" style="background-color: #5D4037;">
                            <i class="ph ph-list me-1"></i> Daftar Buku
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-dark rounded-pill px-4">
                            <i class="ph ph-arrow-left me-1"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
