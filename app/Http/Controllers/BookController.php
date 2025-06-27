<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::with('category', 'reviews')->latest()->paginate(12);



        return view('user.books.index', compact('books'));
    }

    public function popular()
    {
        // Ambil buku beserta review dan kategori
        $books = Book::with(['category', 'reviews'])
            ->where('view_count', '>', 0)
            ->get()
            // Filter hanya yang rating > 4
            ->filter(function ($book) {
                return $book->reviews->avg('rating') > 4;
            })
            // Urutkan berdasarkan view_count (besar ke kecil)
            ->sortByDesc('view_count')
            // Ambil hanya 8 buku
            ->take(8);

        return view('user.books.popular', compact('books'));
    }


    public function show($id)
    {
        $book = Book::with(['category', 'reviews.user'])->findOrFail($id);

        // Rekomendasi
        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->latest()
            ->take(4)
            ->get();

        $reviews = $book->reviews;
        $totalReviews = $reviews->count();
        $reviewCounts = $reviews->groupBy('rating')->map->count();
        $reviewDistribution = $reviewCounts->map(fn($count) => ($count / max($reviews->count(), 1)) * 100);

        $averageRating = $reviews->avg('rating') ?? 0;
        // dd($totalReviews);

        return view('user.books.show', compact('book', 'relatedBooks', 'totalReviews', 'reviewCounts', 'reviewDistribution', 'averageRating'));
    }
}
