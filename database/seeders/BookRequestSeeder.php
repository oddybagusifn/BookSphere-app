<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\BookRequest;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BookRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();

        foreach (range(1, 10) as $i) {
            BookRequest::create([
                'user_id' => $users->random()->id,
                'title' => 'Usulan Buku ' . $i,
                'author' => 'Penulis Baru ' . $i,
                'status' => 'pending',
            ]);
        }
    }
}
