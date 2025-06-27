<?php

namespace App\Http\Controllers\User;

use App\Models\Book;
use App\Http\Controllers\Controller;

class HomepageController extends Controller
{
    public function index()
    {
        // 3 buku acak untuk carousel
        $carouselBooks = Book::inRandomOrder()->limit(3)->get();

        // Buku populer berdasarkan view_count dan rating > 4
        $popularBooks = Book::with('reviews')
            ->where('view_count', '>', 0)
            ->get()
            ->filter(function ($book) {
                $book->average_rating = $book->reviews->avg('rating') ?? 0;
                return $book->average_rating > 4;
            })
            ->sortByDesc('view_count')
            ->values()
            ->take(3);


        // 8 buku terbaru
        $newestBooks = Book::latest()->limit(8)->get();

        return view('user.homepage', compact(
            'carouselBooks',
            'popularBooks',
            'newestBooks'
        ));
    }
}
