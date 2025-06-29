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
        $book = Book::with(['category'])->findOrFail($id);

        // Rekomendasi buku sejenis
        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->latest()
            ->take(4)
            ->get();

        // Ambil semua review untuk kebutuhan statistik
        $allReviews = $book->reviews()->with('user')->latest()->get();

        // Jika query ?all=true, tampilkan semua review
        if (request('all') === 'true') {
            $reviews = $allReviews;
        } else {
            $reviews = $book->reviews()->with('user')->latest()->paginate(3);
        }

        // Hitung statistik review
        $totalReviews = $allReviews->count();
        $averageRating = $book->average_rating;

        $reviewCounts = collect(range(1, 5))->mapWithKeys(function ($i) use ($allReviews) {
            return [$i => $allReviews->where('rating', $i)->count()];
        });

        $reviewDistribution = $reviewCounts->map(function ($count) use ($totalReviews) {
            return $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        });

        return view('user.books.show', compact(
            'book',
            'relatedBooks',
            'reviews',
            'totalReviews',
            'reviewCounts',
            'reviewDistribution',
            'averageRating'
        ));
    }



    public function ajaxSearch(Request $request)
    {
        $query = $request->get('query');

        $books = Book::with(['category', 'reviews'])
            ->when($query, function ($q) use ($query) {
                $q->where('title', 'like', "%$query%")
                    ->orWhere('author', 'like', "%$query%")
                    ->orWhere('published_year', 'like', "%$query%")
                    ->orWhereHas('category', function ($q2) use ($query) {
                        $q2->where('name', 'like', "%$query%");
                    });
            })
            ->get();

        $html = '';
        foreach ($books as $book) {
            $averageRating = number_format($book->reviews->avg('rating') ?? 0, 1);
            $html .= view('book_card_inline', compact('book', 'averageRating'))->render();
        }

        return response()->json(['html' => $html]);
    }



}
