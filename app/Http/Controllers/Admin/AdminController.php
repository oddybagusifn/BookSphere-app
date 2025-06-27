<?php

namespace App\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\User;
use App\Models\Category;
use App\Models\Borrowing;
use App\Models\BookRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    // Halaman dashboard
    public function index()
    {
        $monthlyBorrows = DB::table('borrowings')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $borrowsData = [];
        for ($i = 1; $i <= 12; $i++) {
            $borrowsData[] = $monthlyBorrows[$i] ?? 0;
        }


        return view('admin.dashboard', [
            'totalBooks'     => Book::count(),
            'totalUsers'     => User::where('role', 'user')->count(),
            'totalBorrows'   => Borrowing::count(),
            'totalRequests'  => BookRequest::count(),
            'latestBooks'    => Book::with('category')->latest()->take(5)->get(),
            'borrowsData'    => $borrowsData,
            'latestBorrowings' => Borrowing::with(['user', 'book'])->orderBy('borrowed_at', 'desc')->limit(10)->get(),
            'categories' => Category::latest()->get(),
        ]);
    }

    // Form tambah buku
    public function create()
    {
        $categories = Category::all();
        return view('admin.book-create', compact('categories'));
    }

    // Simpan buku baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'description'  => 'nullable|string',
            'cover'        => 'nullable|image|max:20480',
        ]);

        // Simpan file ke public/covers/
        if ($request->hasFile('cover')) {
            $file     = $request->file('cover');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('covers'), $filename);
            $validated['cover_url'] = 'covers/' . $filename;
        }

        Book::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Buku berhasil ditambahkan!');
    }

    // Tampilkan detail buku
    public function show(Book $book)
    {
        return view('admin.book-show', compact('book'));
    }

    // Form edit buku
    public function edit(Book $book)
    {
        $categories = Category::all();
        return view('admin.book-edit', compact('book', 'categories'));
    }

    // Simpan perubahan buku
    public function update(Request $request, Book $book)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'author'       => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'description'  => 'nullable|string',
            'cover'        => 'nullable|image|max:20480',
        ]);

        // Jika ada file baru, simpan ke public/covers/
        if ($request->hasFile('cover')) {
            $filename = time() . '_' . $request->file('cover')->getClientOriginalName();
            $request->file('cover')->move(public_path('covers'), $filename);
            $validated['cover_url'] = 'covers/' . $filename;
        }


        $book->update($validated);

        return redirect()->route('admin.books')->with('success', 'Buku berhasil diperbarui!');
    }

    // Hapus buku
    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books')->with('success', 'Buku berhasil dihapus!');
    }


    public function books()
    {
        $books = Book::with('category')->latest()->paginate(10);
        $totalBooks = Book::count();
        return view('admin.book-page', compact('books', 'totalBooks'));
    }
}
