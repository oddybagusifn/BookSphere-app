<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all();

        foreach (range(1, 20) as $i) {
            Book::create([
                'title' => 'Buku Contoh ' . $i,
                'author' => 'Penulis ' . $i,
                'category_id' => $categories->random()->id,
                'cover_url' => 'https://via.placeholder.com/150x220?text=Buku+' . $i,
            ]);
        }
    }
}
