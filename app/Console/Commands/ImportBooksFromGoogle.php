<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Str;

class ImportBooksFromGoogle extends Command
{
    protected $signature = 'googlebooks:import {query}';
    protected $description = 'Import books from Google Books API based on search query';

    public function handle()
    {
        $query = $this->argument('query');
        $this->info("🔍 Mencari buku dengan kata kunci: $query...");

        $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
            'q' => $query,
            'maxResults' => 20,
            'printType' => 'books',
        ]);

        if (!$response->ok()) {
            $this->error("❌ Gagal mengambil data dari Google Books.");
            return;
        }

        $items = $response->json()['items'] ?? [];

        if (empty($items)) {
            $this->warn('⚠️ Tidak ada buku ditemukan.');
            return;
        }

        foreach ($items as $item) {
            $volume = $item['volumeInfo'] ?? [];
            $access = $item['accessInfo'] ?? [];

            $googleId = $item['id'] ?? null;
            $title = $volume['title'] ?? null;
            $author = $volume['authors'][0] ?? 'Tidak diketahui';
            $publisher = $volume['publisher'] ?? null;
            $isbn = $volume['industryIdentifiers'][0]['identifier'] ?? null;

            $yearRaw = $volume['publishedDate'] ?? null;
            $year = $yearRaw ? intval(substr($yearRaw, 0, 4)) : null;
            $publishedYear = ($year >= 1900 && $year <= 2155) ? $year : null;

            if (!$googleId || !$title) {
                continue;
            }

            $pageCount = $volume['pageCount'] ?? null;
            $language = $volume['language'] ?? 'unknown';
            $description = $volume['description'] ?? null;
            $rating = $volume['averageRating'] ?? null;
            $ratingCount = $volume['ratingsCount'] ?? 0;

            $imageLinks = $volume['imageLinks'] ?? [];
            $coverUrl = $imageLinks['extraLarge']
                ?? $imageLinks['large']
                ?? $imageLinks['medium']
                ?? $imageLinks['small']
                ?? $imageLinks['thumbnail']
                ?? null;

            // ✅ Gunakan previewLink sebagai read_url
            $readUrl = $volume['previewLink'] ?? null;
            $readable = !empty($readUrl);

            // ⛔ Skip jika tidak ada read_url (tidak bisa dibaca)
            if (!$readable) {
                continue;
            }

            $categoryName = $volume['categories'][0] ?? 'Umum';
            $category = Category::firstOrCreate(
                ['name' => $categoryName],
                ['slug' => Str::slug($categoryName)]
            );

            Book::updateOrCreate(
                ['google_id' => $googleId],
                [
                    'title' => $title,
                    'author' => $author,
                    'publisher' => $publisher,
                    'isbn' => $isbn,
                    'google_id' => $googleId,
                    'published_year' => $publishedYear,
                    'page_count' => $pageCount,
                    'language' => $language,
                    'synopsis' => $description,
                    'cover_url' => $coverUrl,
                    'read_url' => $readUrl,
                    'is_readable' => true,
                    'source' => 'google',
                    'view_count' => rand(100, 1000),
                    'rating' => $rating,
                    'rating_count' => $ratingCount,
                    'category_id' => $category->id,
                ]
            );

            $this->info("✔ Imported: $title ✅ Read URL");
        }

        $this->info("🎉 Import selesai.");
    }
}
