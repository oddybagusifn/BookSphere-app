<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\User;
use App\Models\Borrowing;
use Illuminate\Support\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BorrowingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $books = Book::all();

        foreach (range(1, 60) as $i) {
            // Ambil bulan acak antara 1–6 bulan ke belakang
            $monthsAgo = rand(0, 5);
            $day = rand(1, 28); // Hindari tanggal overflow seperti 30/31 Feb

            $borrowedDate = Carbon::now()->subMonths($monthsAgo)->setDay($day);

            Borrowing::create([
                'user_id'     => $users->random()->id,
                'book_id'     => $books->random()->id,
                'borrowed_at' => $borrowedDate,
                'returned_at' => rand(0, 1) ? $borrowedDate->copy()->addDays(rand(1, 14)) : null,
                'created_at'  => $borrowedDate, // penting untuk grafik
                'updated_at'  => $borrowedDate,
            ]);
        }
    }
}
