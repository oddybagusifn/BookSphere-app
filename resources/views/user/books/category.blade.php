@extends('layouts.app')

@section('content')
    <div class="container-fluid py-5">
        <h4 class="text-accent fw-bold mb-3">
            <i class="ph ph-list-bullets me-2"></i> Kategori Buku
        </h4>
        <p class="text-muted mb-4">Jelajahi berbagai kategori buku yang tersedia di perpustakaan kami.</p>

        <div class="row d-flex justify-content-center row-cols-4 row-cols-sm-6 row-cols-md-8 row-cols-lg-12 row-cols-xl-16 g-3 mb-4">
            @foreach ($categories as $category)
                @php
                    $gradient = 'linear-gradient(135deg, #5D4037, #000000)';
                @endphp

                <div class="col">
                    <a href="{{ route('user.categories.show', $category->id) }}" class="text-decoration-none">
                        <div class="card rounded-pill text-center  shadow-sm"
                            style="background: #fffff}; color: #fff; height: 35px;border: 1px solid #5D4037">
                            <div class="d-flex justify-content-center align-items-center h-100">
                                <span class="fw-medium" style="font-size: 14px;color: #5D4037;">{{ $category->name }}</span>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>

        {{-- Buku Berdasarkan Kategori --}}
        @php
            $icons = [
                'Fiction' => 'ph-book-open-text',
                'Non-Fiction' => 'ph-notebook',
                'History' => 'ph-archive',
                'Technology' => 'ph-cpu',
                'Science' => 'ph-flask',
                'Education' => 'ph-graduation-cap',
                'Religion' => 'ph-hand-praying',
                'Comics' => 'ph-smiley-wink',
                'Novel' => 'ph-quotes',
                'Children' => 'ph-baby',
            ];
        @endphp

        @foreach ($categories->take(8) as $category)
            @php
                $icon = $icons[$category->name] ?? 'ph-books';
            @endphp

            <div class="mb-5">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0" style="color: #5D4037">
                        <i class="ph {{ $icon }} me-2"></i> {{ $category->name }}
                    </h5>
                    <a href="{{ route('user.categories.show', $category->id) }}"
                        class="btn btn-sm fw-semibold rounded-pill px-3 py-1"
                        style="border: 1px solid #5D4037; color: #5D4037; transition: 0.3s;">
                        Lihat semua <i class="ph ph-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="row g-3" id="bookCards">
                    @forelse ($category->books->take(4) as $book)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3 book-card" data-title="{{ strtolower($book->title) }}"
                            data-author="{{ strtolower($book->author) }}" data-year="{{ $book->published_year }}"
                            data-category="{{ strtolower($book->category->name ?? 'umum') }}">
                            <div class="card border-0 rounded-4 h-100 d-flex flex-column overflow-hidden bg-white p-4"
                                style="box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);">

                                {{-- Gambar Buku dengan Background Blur --}}
                                <div class="position-relative overflow-hidden mb-4"
                                    style="height: 240px; border-radius: 0.5rem;">
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

                                {{-- Judul dan Penulis --}}
                                <div class="mb-1 d-flex justify-content-between align-items-center">
                                    <h5 class="fw-bold text-dark">{{ $book->title }}</h5>
                                    @php $averageRating = number_format($book->reviews->avg('rating') ?? 0, 1); @endphp
                                    <div class="d-flex align-items-center fs-6 gap-1 text-warning small">
                                        @for ($i = 1; $i <= 1; $i++)
                                            <i class="ph {{ $i <= round($averageRating) ? 'ph-star' : 'ph-star' }}"></i>
                                        @endfor
                                        <span class="text-muted ms-1">({{ $averageRating }})</span>
                                    </div>
                                </div>
                                <p class="text-muted mb-2" style="font-size: 0.9rem;">{{ $book->author }}</p>

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
                                <div class="d-flex align-items-center gap-2">
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
                    @empty
                        <p class="text-muted">Belum ada buku di kategori ini.</p>
                    @endforelse
                </div>
            </div>
        @endforeach
        <div class="mt-3 d-flex justify-content-center">
            {{ $category->books()->paginate(8)->links() }}
        </div>
    </div>
@endsection
