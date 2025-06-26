<?php

namespace App\Http\Controllers\Admin;

use App\Models\Borrowing;
use Illuminate\Http\Request;
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

    // Data untuk grafik bulanan
    $borrowsData = Borrowing::selectRaw('MONTH(borrowed_at) as month, COUNT(*) as total')
        ->groupBy('month')
        ->pluck('total', 'month')
        ->toArray();

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
