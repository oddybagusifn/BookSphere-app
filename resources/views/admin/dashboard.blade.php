@extends('layouts.app')

@section('content')
    <section class="py-5 min-vh-100">
        <div class="container-fluid">
            <!-- Heading -->
            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
                <h2 class="fw-bold text-accent">
                    <i class="ph ph-books me-2"></i> Dashboard Admin
                </h2>
                <a href="{{ route('admin.books.create') }}" class="btn rounded-pill fw-semibold text-light px-4 py-2"
                    style="background-color: #5D4037;">
                    <i class="ph ph-plus-circle me-1"></i> Tambah Buku
                </a>
            </div>

            <!-- Grafik -->
            <div class="card border-0 shadow-sm rounded-4 mb-5">
                <div class="card-body">
                    <h5 class="fw-bold text-accent mb-4">Grafik Peminjaman Bulanan</h5>
                    <canvas id="borrowChart" height="70"></canvas>
                </div>
            </div>

            <!-- Statistik -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 mb-5">
                @php
                    $stats = [
                        [
                            'icon' => 'ph-books',
                            'title' => 'Total Buku',
                            'count' => $totalBooks,
                            'color' => 'linear-gradient(135deg, #4E342E, #BCAAA4)',
                            'text' => 'white',
                        ],
                        [
                            'icon' => 'ph-users',
                            'title' => 'Pengguna',
                            'count' => $totalUsers,
                            'color' => 'linear-gradient(135deg, #3E2723, #8D6E63)',
                            'text' => 'white',
                        ],
                        [
                            'icon' => 'ph-book-open',
                            'title' => 'Peminjaman',
                            'count' => $totalBorrows,
                            'color' => 'linear-gradient(135deg, #5D4037, #424242)',
                            'text' => 'white',
                        ],
                        [
                            'icon' => 'ph-lightbulb',
                            'title' => 'Request Buku',
                            'count' => $totalRequests,
                            'color' => 'linear-gradient(135deg, #D7CCC8, #A1887F)',
                            'text' => 'dark',
                        ],
                    ];
                @endphp

                @foreach ($stats as $stat)
                    <div class="col">
                        <div class="card shadow-sm rounded-4 border-0 text-{{ $stat['text'] }}"
                            style="background: {{ $stat['color'] }}; min-height: 160px;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center gap-3">
                                    <i class="ph {{ $stat['icon'] }}" style="font-size: 36px;"></i>
                                    <div>
                                        <div class="fs-6 {{ $stat['text'] === 'dark' ? 'text-muted' : 'text-white-50' }}">
                                            {{ $stat['title'] }}
                                        </div>
                                        <div class="fs-4 fw-bold">{{ $stat['count'] }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Buku Terbaru -->
            <div class="card border-0 rounded-4 shadow-sm mb-5">
                <div class="card-header text-white rounded-top-4 px-4 py-3 d-flex align-items-center"
                    style="background: linear-gradient(135deg, #826e6a, #3E2723);">
                    <i class="ph ph-list me-2"></i>
                    <h5 class="mb-0 fw-semibold">Buku Terbaru</h5>
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
                                @forelse ($latestBooks as $book)
                                    <tr>
                                        <td class="px-3 py-3 align-middle">{{ $book->title }}</td>
                                        <td class="px-3 py-3 align-middle">{{ $book->author }}</td>
                                        <td class="px-3 py-3 align-middle">{{ $book->category->name ?? '-' }}</td>
                                        <td class="px-3 py-3 align-middle">{{ $book->created_at->format('d M Y') }}</td>
                                        <td class="px-3 py-3 align-middle">
                                            <div class="d-flex justify-content-center gap-3 flex-wrap">
                                                <a href="{{ route('admin.books.show', $book->id) }}"
                                                    class="btn rounded-pill btn-sm mainButton border border-dark">
                                                    <i class="ph ph-eye me-1"></i> Lihat
                                                </a>
                                                <a href="{{ route('admin.books.edit', $book->id) }}"
                                                    class="btn rounded-pill btn-sm btn-outline-dark">
                                                    <i class="ph ph-pencil-simple me-1"></i> Edit
                                                </a>
                                                <form action="{{ route('admin.books.destroy', $book->id) }}" method="POST"
                                                    class="d-inline"
                                                    onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="btn rounded-pill btn-sm btn-danger text-white">
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
                </div>
            </div>

            <!-- List Kategori -->
            <div class="card border-0 rounded-4 shadow-sm mb-5">
                <div class="card-header text-white rounded-top-4 px-4 py-3 d-flex align-items-center"
                    style="background: linear-gradient(135deg, #5D4037, #3E2723);">
                    <i class="ph ph-books me-2"></i>
                    <h5 class="mb-0 fw-semibold">Daftar Kategori Buku</h5>
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        @forelse ($categories as $category)
                            <div class="col">
                                <div class="card border-0 shadow-sm rounded-4">
                                    <div class="card-body p-4 d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="mb-1">{{ $category->name }}</h5>
                                            <small class="text-white-50">Ditambahkan:
                                                {{ $category->created_at->format('d M Y') }}</small>
                                        </div>
                                        <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                            method="POST" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')"
                                            class="ms-2">
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
            </div>

            <!-- Peminjaman Terbaru -->
            <div class="card border-0 rounded-4 shadow-sm mb-5">
                <div class="card-header text-white rounded-top-4 px-4 py-3 d-flex align-items-center"
                    style="background: linear-gradient(135deg, #3E2723, #212121);">
                    <i class="ph ph-bookmark me-2"></i>
                    <h5 class="mb-0 fw-semibold">Peminjaman Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="bg-light text-center">
                                <tr>
                                    <th class="px-3 py-3">Nama Pengguna</th>
                                    <th class="px-3 py-3">Judul Buku</th>
                                    <th class="px-3 py-3">Tanggal Pinjam</th>
                                    <th class="px-3 py-3">Tanggal Kembali</th>
                                    <th class="px-3 py-3">Status</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @forelse ($latestBorrowings as $borrow)
                                    <tr>
                                        <td class="px-3 py-3 align-middle">{{ $borrow->user->username }}</td>
                                        <td class="px-3 py-3 align-middle">{{ $borrow->book->title }}</td>
                                        <td class="px-3 py-3 align-middle">
                                            {{ \Carbon\Carbon::parse($borrow->borrowed_at)->format('d M Y') }}
                                        </td>
                                        <td class="px-3 py-3 align-middle">
                                            @if ($borrow->returned_at)
                                                {{ \Carbon\Carbon::parse($borrow->returned_at)->format('d M Y') }}
                                            @else
                                                <span class="text-muted">Belum kembali</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3 align-middle">
                                            @if ($borrow->returned_at)
                                                <span class="badge rounded-pill bg-success">Dikembalikan</span>
                                            @else
                                                <span class="badge rounded-pill bg-warning text-dark">Sedang
                                                    Meminjam</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            Belum ada peminjaman.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const ctx = document.getElementById('borrowChart').getContext('2d');
        const borrowChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                datasets: [{
                    label: 'Peminjaman',
                    data: @json($borrowsData),
                    backgroundColor: 'rgba(93, 64, 55, 0.2)',
                    borderColor: '#5D4037',
                    borderWidth: 3,
                    tension: 0.4,
                    pointBackgroundColor: '#5D4037',
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: '#5D4037'
                        },
                        grid: {
                            color: '#f0f0f0'
                        }
                    },
                    x: {
                        ticks: {
                            color: '#5D4037'
                        },
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
@endpush
