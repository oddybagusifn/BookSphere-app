<?php

namespace App\Http\Controllers\Admin;

use App\Models\Borrowing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'book'])
            ->orderBy('borrowed_at', 'desc')
            ->paginate(10)
            ->onEachSide(3);

        $totalBorrowings = Borrowing::count();

        // Deteksi driver database (pgsql atau mysql)
        $driver = DB::getDriverName();

        if ($driver === 'pgsql') {
            // PostgreSQL pakai EXTRACT
            $borrowsData = Borrowing::selectRaw('EXTRACT(MONTH FROM borrowed_at) as month, COUNT(*) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month')
                ->toArray();
        } else {
            // MySQL/MariaDB pakai MONTH()
            $borrowsData = Borrowing::selectRaw('MONTH(borrowed_at) as month, COUNT(*) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('total', 'month')
                ->toArray();
        }

        // Susun data untuk 12 bulan (jika ada bulan tanpa data, isi 0)
        $borrowCounts = [];
        for ($i = 1; $i <= 12; $i++) {
            $borrowCounts[] = $borrowsData[$i] ?? 0;
        }

        // Cari buku yang paling sering dipinjam
        $mostBorrowedBook = Borrowing::select('book_id')
            ->groupBy('book_id')
            ->orderByRaw('COUNT(*) DESC')
            ->with('book')
            ->first()?->book;

        return view('admin.borrowings.index', [
            'borrowings' => $borrowings,
            'totalBorrowings' => $totalBorrowings,
            'borrowsData' => $borrowCounts,
            'mostBorrowedBook' => $mostBorrowedBook,
        ]);
    }
}
