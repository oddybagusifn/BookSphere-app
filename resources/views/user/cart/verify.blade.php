@extends('layouts.app')

@section('content')
    <div class="container-fluid py-5">
        <h4 class="fw-bold mb-4 text-accent">
            <i class="ph ph-book-bookmark me-2"></i> Verifikasi Peminjaman
        </h4>

        <form action="{{ route('verify.submit') }}" method="POST">
            @csrf

            <div class="row">
                {{-- Kolom Kiri: Daftar Buku --}}
                <div class="col-lg-8 mb-4">
                    <label class="form-label fw-semibold text-dark">Daftar Buku yang Akan Dipinjam:</label>
                    <div class="row row-cols-1 row-cols-md-2 g-4">
                        @foreach ($cart as $item)
                            @php
                                $book = $item->book;
                            @endphp
                            <div class="col">
                                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                                    <div class="row g-0 h-100">

                                        {{-- Gambar Buku dengan Background Blur dan Gradasi --}}
                                        <div class="col-md-4 position-relative"
                                            style="min-height: 160px; border-top-left-radius: 1rem; border-bottom-left-radius: 1rem; overflow: hidden;">
                                            <div class="position-absolute top-0 start-0 w-100 h-100"
                                                style="background: url('{{ $book->cover_url ?? '/default-book.png' }}') center center / cover no-repeat;
                            filter: blur(4px) brightness(0.6); z-index: 1;">
                                            </div>
                                            <div class="position-absolute top-0 start-0 w-100 h-100"
                                                style="z-index: 2; background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.8));">
                                            </div>
                                            <div class="position-relative d-flex justify-content-center align-items-center h-100"
                                                style="z-index: 3;">
                                                <img src="{{ $book->cover_url ?? '/default-book.png' }}"
                                                    alt="{{ $book->title }}" class="img-fluid rounded shadow"
                                                    style="max-height: 120px; object-fit: contain;">
                                            </div>
                                        </div>

                                        {{-- Konten Buku --}}
                                        <div class="col-md-8 p-3">
                                            <small class="text-muted">Informasi Buku</small>
                                            <h5 class="fw-bold mb-1 text-dark">{{ $book->title }}</h5>

                                            <p class="text-muted mb-3" style="font-size: 0.95rem;">
                                                {{ Str::limit(strip_tags($book->synopsis ?? 'Tidak ada sinopsis.'), 100) }}
                                            </p>

                                            <div class="d-flex flex-wrap gap-2">
                                                <span class="badge rounded-pill px-3 py-1 border border-dark text-dark">
                                                    ISBN: {{ $book->isbn ?? '-' }}
                                                </span>
                                                <span class="badge rounded-pill px-3 py-1 border border-dark text-dark">
                                                    Kategori: {{ $book->category->name ?? '-' }}
                                                </span>
                                                <span class="badge rounded-pill px-3 py-1 border border-dark text-dark">
                                                    Tahun: {{ $book->published_year ?? '-' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 h-100 d-flex align-items-stretch">
                        <div class="mb-4">
                            <label for="duration" class="form-label fw-semibold text-dark">Pilih Durasi Peminjaman:</label>
                            <select name="duration" id="duration"
                                class="form-select rounded-pill border-dark bg-white text-dark" required>
                                <option value="">-- Pilih Durasi --</option>
                                <option value="3">3 Hari</option>
                                <option value="7">1 Minggu</option>
                                <option value="14">2 Minggu</option>
                            </select>
                        </div>

                        <div class="form-check mb-4">
                            <input class="form-check-input custom-checkbox" type="checkbox" id="agreeCheck">
                            <label class="form-check-label text-dark" for="agreeCheck">
                                Saya setuju untuk mengembalikan buku tepat waktu dan dalam kondisi baik.
                            </label>
                        </div>

                        <button type="submit" class="btn fw-semibold rounded-pill w-100 text-white"
                            style="background: linear-gradient(to right, #ccc, #ccc);" id="submitButton" disabled>
                            Konfirmasi & Pinjam
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- Script Aktivasi Button --}}
    <script>
        document.getElementById('agreeCheck').addEventListener('change', function() {
            const btn = document.getElementById('submitButton');
            if (this.checked) {
                btn.disabled = false;
                btn.style.background = 'linear-gradient(to right, #5D4037, #8d7b7b)';
            } else {
                btn.disabled = true;
                btn.style.background = 'linear-gradient(to right, #ccc, #ccc)';
            }
        });
    </script>
@endsection
