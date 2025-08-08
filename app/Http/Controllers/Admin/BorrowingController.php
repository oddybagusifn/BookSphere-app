<?php

namespace App\Http\Controllers\Admin;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BorrowingController extends Controller
{
    /**
     * Display a listing of borrowings with statistics.
     */
    public function index()
    {
        // Data peminjaman dengan relasi user & book
        $borrowings = Borrowing::with(['user', 'book'])
            ->orderBy('borrowed_at', 'desc')
            ->paginate(10)
            ->onEachSide(3);

        // Total semua peminjaman
        $totalBorrowings = Borrowing::count();

        // Deteksi driver database (pgsql atau mysql/mariadb)
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            // PostgreSQL → gunakan EXTRACT untuk ambil bulan
            $borrowsData = Borrowing::selectRaw('EXTRACT(MONTH FROM borrowed_at) AS month, COUNT(*) AS total')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month')
                ->toArray();
        } else {
            // MySQL/MariaDB → gunakan fungsi MONTH()
            $borrowsData = Borrowing::selectRaw('MONTH(borrowed_at) AS month, COUNT(*) AS total')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month')
                ->toArray();
        }

        // Susun array untuk 12 bulan (isi 0 jika bulan tidak ada data)
        $borrowCounts = [];
        for ($i = 1; $i <= 12; $i++) {
            $borrowCounts[] = $borrowsData[$i] ?? 0;
        }

        // Buku yang paling sering dipinjam
        $mostBorrowedBook = Borrowing::select('book_id')
            ->groupBy('book_id')
            ->orderByRaw('COUNT(*) DESC')
            ->with('book')
            ->first()?->book;

        return view('admin.borrowings.index', [
            'borrowings'        => $borrowings,
            'totalBorrowings'   => $totalBorrowings,
            'borrowsData'       => $borrowCounts,
            'mostBorrowedBook'  => $mostBorrowedBook,
        ]);
    }
}
