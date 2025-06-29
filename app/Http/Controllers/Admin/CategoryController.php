<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        $totalCategories = $categories->count();

        return view('admin.categories.index', compact('categories', 'totalCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
        ]);

        Category::create(['name' => $request->name]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')->with('success', 'Kategori berhasil dihapus.');
    }


    public function search(Request $request)
    {
        $search = $request->query('search');

        $categories = Category::where('name', 'like', '%' . $search . '%')
            ->orderBy('name')
            ->take(10)
            ->get(['name']);

        return response()->json($categories);
    }
}
