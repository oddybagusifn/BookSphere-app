@extends('layouts.app')

@section('content')
    <div class="container-fluid vh-100 py-5">
        <h4 class="text-accent fw-bold mb-3">
            <i class="ph ph-books me-2"></i> Buku di Kategori: {{ $category->name }}
        </h4>

        @if ($books->isEmpty())
            <p class="text-muted">Tidak ada buku di kategori ini.</p>
        @else
            <div class="row g-3" id="bookCards">
                @foreach ($books as $book)
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 book-card" data-title="{{ strtolower($book->title) }}"
                        data-author="{{ strtolower($book->author) }}" data-year="{{ $book->published_year }}"
                        data-category="{{ strtolower($book->category->name ?? 'umum') }}">
                        <div class="card border-0 rounded-4 h-100 overflow-hidden bg-white p-4"
                            style="box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">

                            {{-- Gambar --}}
                            <div class="position-relative overflow-hidden mb-4"
                                style="height: 220px; border-radius: 0.5rem;">
                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                    style="background: url('{{ $book->cover_url }}') center center / cover no-repeat;
                                filter: blur(2px) brightness(0.6); z-index: 1;">
                                </div>
                                <div class="position-absolute top-0 start-0 w-100 h-100"
                                    style="z-index: 2; background: radial-gradient(rgba(0, 0, 0, 0) 30%, rgba(0, 0, 0, 0.4) 100%);">
                                </div>
                                <div class="position-relative d-flex justify-content-center align-items-center h-100"
                                    style="z-index: 3;">
                                    <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="rounded shadow"
                                        style="max-height: 100%; max-width: 100%; object-fit: contain;">
                                </div>
                            </div>

                            <h5 class="fw-bold text-dark mb-1">{{ $book->title }}</h5>
                            <p class="text-muted small">{{ $book->author }}</p>
                            <p class="text-muted small">{{ Str::limit(strip_tags($book->synopsis), 100) }}</p>

                            <div class="d-flex gap-2 mt-auto">
                                <form action="{{ route('cart.add') }}" method="POST" class="d-inline-block mb-1">
                                    @csrf
                                    <input type="hidden" name="book_id" value="{{ $book->id }}">
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
        @endif
    </div>
@endsection
