<?php

namespace App\Http\Controllers\User;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        // Ambil semua kategori dengan relasi buku (maksimal 4 buku per kategori)
        $categories = Category::with(['books' => function ($query) {
            $query->latest()->take(4)->with('reviews');
        }])->get();

        return view('user.books.category', compact('categories'));
    }

    public function show($id)
    {
        $category = Category::findOrFail($id); // Ambil berdasarkan ID
        $books = $category->books()->latest()->get(); // Ambil buku berdasarkan relasi

        return view('user.books.category-show', compact('category', 'books'));
    }
}
