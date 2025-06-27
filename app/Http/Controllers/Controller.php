<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function index()
    {
        // Ambil semua buku dengan relasi kategori, urutkan berdasarkan waktu ditambahkan
        $books = Book::with('category')->latest()->paginate(12); // 12 buku per halaman

        return view('user.books.index', compact('books'));
    }
}
