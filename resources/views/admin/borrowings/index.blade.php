@extends('layouts.app')

@section('content')
    <section class="py-5 px-3 px-md-5 min-vh-100">
        <div class="container">

            <!-- Judul Halaman -->
            <h3 class="fw-bold text-accent mb-4 d-flex align-items-center">
                <i class="ph ph-bookmark me-2"></i> Daftar Peminjaman Buku
            </h3>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4 mb-5">
                <div class="col">
                    <div class="card shadow-sm rounded-4 border-0 text-white"
                        style="background: linear-gradient(135deg, #5D4037, #424242); min-height: 140px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center gap-3">
                                <i class="ph ph-bookmark" style="font-size: 36px;"></i>
                                <div>
                                    <div class="fs-6 text-white-50">Total Peminjaman</div>
                                    <div class="fs-4 fw-bold">{{ $totalBorrowings }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card shadow-sm rounded-4 border-0 text-white"
                        style="background: linear-gradient(135deg, #4E342E, #b4a19b); min-height: 140px;">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-start gap-3">
                                <i class=" ph ph-fire" style="font-size: 36px;"></i>
                                <div>
                                    <div class="fs-6 text-white-50">Buku Terpopuler</div>
                                    @if ($mostBorrowedBook)
                                        <div class="fw-bold fs-5">{{ $mostBorrowedBook->title }}</div>
                                        <small class="text-white-50">by {{ $mostBorrowedBook->author }}</small>
                                    @else
                                        <div class="text-muted">Belum ada data</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 rounded-4 shadow-sm mb-5">
                <div class="card-body">
                    <h5 class="fw-bold text-accent mb-4">Grafik Peminjaman Bulanan</h5>
                    <canvas id="borrowChart" height="70"></canvas>
                </div>
            </div>

            <!-- Tabel Peminjaman -->
            <div class="card border-0 rounded-4 shadow-sm">
                <div class="card-header bg-accent text-white rounded-top-4 px-4 py-3 d-flex align-items-center">
                    <i class="ph ph-bookmark me-2"></i>
                    <h5 class="mb-0 fw-semibold">Semua Riwayat Peminjaman</h5>
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
                                @forelse ($borrowings as $borrow)
                                    <tr>
                                        <td class="px-3 py-3 align-middle">{{ $borrow->user->username }}</td>
                                        <td class="px-3 py-3 align-middle">{{ $borrow->book->title }}</td>
                                        <td class="px-3 py-3 align-middle">
                                            {{ \Carbon\Carbon::parse($borrow->borrowed_at)->format('d M Y') }}</td>
                                        <td class="px-3 py-3 align-middle">
                                            @if ($borrow->returned_at)
                                                {{ \Carbon\Carbon::parse($borrow->returned_at)->format('d M Y') }}
                                            @else
                                                <span class="text-muted">Belum kembali</span>
                                            @endif
                                        </td>
                                        <td class="px-3 py-3 align-middle">
                                            @if ($borrow->returned_at && now()->greaterThanOrEqualTo($borrow->returned_at))
                                                <span class="badge rounded-pill bg-success">Dikembalikan</span>
                                            @else
                                                <span class="badge rounded-pill bg-warning text-dark">Sedang Meminjam</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-muted py-4">
                                            Belum ada data peminjaman.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="p-4">
                        <div class="d-flex justify-content-center">
                            {{ $borrowings->links('vendor.pagination.rounded-gap') }}
                        </div>
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
