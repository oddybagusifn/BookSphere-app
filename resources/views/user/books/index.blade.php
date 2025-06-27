@extends('layouts.app')

@section('content')
    <div class="container-fluid py-5">
        <h4 class="text-accent fw-bold mb-3"><i class="ph ph-books me-2"></i> Katalog Buku</h4>
        <p class="text-muted mb-4">Temukan koleksi lengkap buku yang tersedia di perpustakaan kami.</p>

        <div class="row g-3">
            @foreach ($books as $book)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="card border-0 rounded-4 h-100 d-flex flex-column overflow-hidden bg-white p-4"
                        style="box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">

                        {{-- Gambar Buku --}}
                        <div class="d-flex justify-content-center align-items-center mb-4" style="height: 220px;">
                            <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="rounded"
                                style="max-height: 100%; max-width: 100%; object-fit: contain;box-shadow: 0 4px 18px rgba(0, 0, 0, 0.5);">
                        </div>

                        {{-- Judul dan Penulis --}}
                        <div class="mb-1 d-flex justify-content-between  align-items-center">
                            <h5 class="fw-bold text-dark ">{{ $book->title }}</h5>
                            {{-- RATING --}}
                            @php
                                $averageRating = number_format($book->reviews->avg('rating') ?? 0, 1);
                            @endphp
                            <div class="d-flex align-items-center mb-2 fs-6 gap-1 text-warning small">
                                @for ($i = 1; $i <= 1; $i++)
                                    <i class="ph {{ $i <= round($averageRating) ? 'ph-star' : 'ph-star' }}"></i>
                                @endfor
                                <span class="text-muted ms-1 ">({{ $averageRating }})</span>
                            </div>
                        </div>
                        <p class="text-muted mb-2" style="font-size: 0.9rem;">{{ $book->author }}</p>

                        {{-- ISBN & Tahun Terbit --}}
                        <div class="d-flex justify-content-between text-muted small mb-2" style="font-size: 0.85rem;">
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

        <div class="mt-4">
            {{ $books->links() }}
        </div>
    </div>
@endsection
