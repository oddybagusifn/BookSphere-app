@extends('layouts.app')

@section('content')
<section class="py-5 px-3 px-md-5 min-vh-100">
    <div class="container-fluid">
        <!-- Header -->
        <div class="mb-5">
            <h2 class="fw-bold text-accent border-bottom pb-2 d-flex align-items-center">
                <i class="ph ph-book-open me-2 fs-3"></i> Detail Buku
            </h2>
            <p class="text-muted">Informasi lengkap tentang buku yang tersedia.</p>
        </div>

        <div class="row g-4">
            <!-- Cover -->
            <div class="col-12 col-md-6">
                <div class="bg-white shadow-sm rounded-4 overflow-hidden border">
                    @if ($book->cover_url)
                        <img src="{{ $book->cover_url }}" alt="Cover Buku" class="img-fluid w-100 object-fit-cover">
                    @else
                        <div class="d-flex align-items-center justify-content-center text-muted py-5">
                            <i class="ph ph-image fs-1 mb-2"></i>
                            <p class="mb-0">Tidak ada gambar</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Informasi Buku -->
            <div class="col-12 col-md-6">
                <div class="bg-white shadow-sm rounded-4 p-4 border h-100 d-flex flex-column justify-content-between">
                    <div>
                        <h3 class="fw-bold text-accent mb-3">{{ $book->title }}</h3>

                        <ul class="list-unstyled mb-4">
                            <li class="mb-2"><i class="ph ph-user me-2 text-accent"></i> <strong>Penulis:</strong> {{ $book->author }}</li>
                            <li class="mb-2"><i class="ph ph-tag me-2 text-accent"></i> <strong>Kategori:</strong> {{ $book->category->name ?? '-' }}</li>
                            <li class="mb-2"><i class="ph ph-calendar me-2 text-accent"></i> <strong>Ditambahkan:</strong> {{ $book->created_at->format('d M Y') }}</li>
                        </ul>

                        <div>
                            <h5 class="fw-semibold mb-2">Deskripsi Buku</h5>
                            <p class="text-muted" style="text-align: justify;">
                                {{ $book->description ?: 'Belum ada deskripsi untuk buku ini.' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('admin.dashboard') }}" class="btn bg-accent border rounded-pill px-4 me-2">
                            <i class="ph ph-list me-1"></i> Lihat Daftar Buku
                        </a>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-dark border border-dark rounded-pill px-4">
                            <i class="ph ph-arrow-left me-1"></i> Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
