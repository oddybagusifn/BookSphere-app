@extends('layouts.app')

@section('content')
    <section class="py-5 px-3 px-md-5 min-vh-100">
        <div class="container">
            <!-- Judul Halaman -->
            <h3 class="fw-bold text-accent mb-4 d-flex align-items-center">
                <i class="ph ph-list me-2"></i> Daftar Semua Buku
            </h3>

            <!-- Total Buku (Card Grid Style seperti Dashboard) -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 mb-5">
                <div class="col">
                    <div class="card shadow-sm rounded-4 border-0 text-white"
                        style="background: linear-gradient(135deg, #4E342E, #BCAAA4); min-height: 140px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3">
                                <i class="ph ph-book-open" style="font-size: 36px;"></i>
                                <div>
                                    <div class="fs-6 text-white-50">Total Buku</div>
                                    <div class="fs-4 fw-bold">{{ $totalBooks }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Tabel Buku -->
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header bg-accent text-white rounded-top-4 px-4 py-3 d-flex align-items-center">
                    <i class="ph ph-list me-2"></i>
                    <h5 class="mb-0 fw-semibold">Semua Buku</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th class="px-3 py-3">Judul</th>
                                    <th class="px-3 py-3">Penulis</th>
                                    <th class="px-3 py-3">Kategori</th>
                                    <th class="px-3 py-3">Tanggal Tambah</th>
                                    <th class="px-3 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($books as $book)
                                    <tr>
                                        <td class="px-3 py-3 align-middle">{{ $book->title }}</td>
                                        <td class="px-3 py-3 align-middle">{{ $book->author }}</td>
                                        <td class="px-3 py-3 align-middle">{{ $book->category->name ?? '-' }}</td>
                                        <td class="px-3 py-3 align-middle">{{ $book->created_at->format('d M Y') }}</td>
                                        <td class="px-3 py-3 align-middle">
                                            <div class="d-flex justify-content-center gap-2 flex-wrap">
                                                <a href="{{ route('admin.books.show', $book->id) }}"
                                                    class="btn btn-sm btn-outline-dark rounded-pill">
                                                    <i class="ph ph-eye me-1"></i> Lihat
                                                </a>
                                                <a href="{{ route('admin.books.edit', $book->id) }}"
                                                    class="btn btn-sm btn-outline-dark rounded-pill">
                                                    <i class="ph ph-pencil-simple me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger rounded-pill text-white">
                                                        <i class="ph ph-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            Belum ada buku ditambahkan.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="p-4">
                        <div class="d-flex justify-content-center">
                            {{ $books->links('pagination::bootstrap-5') }}
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
