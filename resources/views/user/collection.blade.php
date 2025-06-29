@extends('layouts.app')

@section('content')
    <div class="container-fluid min-vh-100 py-5">
        <h4 class="text-accent fw-bold mb-3">
            <i class="ph ph-book-bookmark me-2"></i> Koleksi Buku Kamu
        </h4>
        <p class="text-muted mb-4">Berikut adalah daftar buku yang sedang kamu pinjam dari perpustakaan digital kami.</p>

        <div class="row row-cols-1 g-4">
            @foreach ($borrowings as $borrow)
                @php
                    $book = $borrow->book;
                    $remainingSeconds = \Carbon\Carbon::now()->diffInSeconds(
                        \Carbon\Carbon::parse($borrow->returned_at),
                        false,
                    );
                @endphp

                <div class="col">
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden w-100 d-flex flex-row">
                        <div class="col-md-4 position-relative d-flex align-items-center justify-content-center"
                            style="min-height: 260px; background-image: url('{{ $book->cover_url }}'); background-size: cover; background-position: center;">
                            <div class="position-absolute top-0 start-0 w-100 h-100"
                                style="backdrop-filter: blur(6px); background: radial-gradient(rgba(0,0,0,0.2), rgba(0,0,0,0.8)); z-index: 1;">
                            </div>
                            <img src="{{ $book->cover_url }}" alt="{{ $book->title }}" class="img-fluid position-relative"
                                style="z-index: 2; max-height: 200px; object-fit: contain;">
                        </div>

                        <div class="col-md-8 p-4 d-flex flex-column">
                            <h4 class="fw-bold text-dark">{{ $book->title }}</h4>
                            <p class="text-muted">oleh <strong>{{ $book->author }}</strong></p>

                            {{-- Info Buku --}}
                            <div class="d-flex flex-wrap gap-4 text-muted small mb-3">
                                @if ($book->isbn)
                                    <div><strong>ISBN:</strong> {{ $book->isbn }}</div>
                                @endif
                                @if ($book->published_year)
                                    <div><strong>Tahun Terbit:</strong> {{ $book->published_year }}</div>
                                @endif
                                @if ($book->page_count)
                                    <div><strong>Halaman:</strong> {{ $book->page_count }}</div>
                                @endif
                            </div>

                            {{-- Kategori --}}
                            <p class="text-muted mb-2">
                                <strong>Kategori:</strong>
                                <span class="badge rounded-pill border border-dark text-dark px-3 py-1">
                                    {{ $book->category->name ?? 'Umum' }}
                                </span>
                            </p>

                            {{-- Sinopsis --}}
                            <div class="mb-3">
                                <h6 class="fw-semibold mb-1">Sinopsis</h6>
                                <p class="text-muted small mb-0">
                                    {{ Str::limit(strip_tags($book->synopsis ?? 'Tidak ada sinopsis'), 180) }}
                                </p>
                            </div>

                            {{-- Countdown Timer --}}
                            <p class="text-dark fw-medium mt-auto mb-3">
                                Sisa Waktu: <span class="text-muted" id="timer-{{ $borrow->id }}">Memuat...</span>
                            </p>

                            <div class="d-flex gap-4">
                                <a href="" class="btn  rounded-pill text-white fw-semibold px-4"
                                    style="background-color: #5D4037">
                                    <i class="ph ph-book-open-text"></i> Mulai Baca
                                </a>

                                <form action="{{ route('user.collection.return', $borrow->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-outline-dark rounded-pill fw-semibold px-4">
                                        <i class="ph ph-arrow-counter-clockwise me-1"></i> Kembalikan
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <script>
                    const countdown{{ $borrow->id }} = () => {
                        const target = new Date("{{ \Carbon\Carbon::parse($borrow->returned_at)->format('Y-m-d H:i:s') }}")
                            .getTime();
                        const now = new Date().getTime();
                        const distance = target - now;

                        if (distance < 0) {
                            document.getElementById("timer-{{ $borrow->id }}").innerText = "Waktu habis";
                            return;
                        }

                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                        document.getElementById("timer-{{ $borrow->id }}").innerText =
                            `${days} hari ${hours} jam ${minutes} menit ${seconds} detik`;
                    }
                    setInterval(countdown{{ $borrow->id }}, 1000);
                </script>
            @endforeach
        </div>

    </div>
@endsection
