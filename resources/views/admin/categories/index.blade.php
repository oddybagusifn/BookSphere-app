@extends('layouts.app')

@section('content')
    <section class="py-5 px-3 px-md-5 min-vh-100">
        <div class="container">

            <!-- Judul Halaman -->
            <h3 class="fw-bold text-accent mb-4 d-flex align-items-center">
                <i class="ph ph-books me-2"></i> Daftar Kategori Buku
            </h3>

            <!-- Total Kategori -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 mb-5">
                <div class="col">
                    <div class="card shadow-sm rounded-4 border-0 text-white"
                        style="background: linear-gradient(135deg, #3E2723, #8D6E63); min-height: 140px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3">
                                <i class="ph ph-books" style="font-size: 36px;"></i>
                                <div>
                                    <div class="fs-6 text-white-50">Total Kategori</div>
                                    <div class="fs-4 fw-bold">{{ $totalCategories }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Tambah Kategori -->
            <div class="card shadow-sm rounded-4 border-0 mb-4">
                <div class="card-body p-4">
                    <h5 class="fw-semibold mb-3">Tambah Kategori Baru</h5>
                    <form action="{{ route('admin.categories.store') }}" method="POST" class="d-flex gap-2 ">
                        @csrf
                        <input type="text" name="name" class="form-control rounded-pill w-75"
                            placeholder="Nama kategori" required>
                        <button type="submit" class="btn rounded-pill px-4 py-3 text-white fw-medium"
                            style="background-color: #3E2723">
                            <div class="d-flex align-items-center">
                                <i class="ph ph-plus-circle me-1" style="font-size: 26px;"></i> Tambah Kategori
                            </div>
                        </button>
                    </form>
                </div>
            </div>

            <!-- List Kategori -->
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse ($categories as $category)
                    <div class="col">
                        <div class="card border-0 shadow-sm rounded-4">
                            <div class="card-body p-4 d-flex justify-content-between align-items-center">
                                <div>
                                    <h5 class="mb-0">{{ $category->name }}</h5>
                                    <small class="text-muted">Ditambahkan:
                                        {{ $category->created_at->format('d M Y') }}</small>
                                </div>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                    onsubmit="return confirm('Yakin ingin menghapus kategori ini?')" class="ms-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger rounded-pill text-white">
                                        <i class="ph ph-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning rounded-4 text-center">
                            Belum ada kategori ditambahkan.
                        </div>
                    </div>
                @endforelse
            </div>

        </div>
    </section>
@endsection
