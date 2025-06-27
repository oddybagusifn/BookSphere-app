<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@booksphere.com'],
            [
                'username' => 'Admin',
                'email' => 'admin@booksphere.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'google_id' => null,
                'avatar' => null,
            ]
        );
    }
}
