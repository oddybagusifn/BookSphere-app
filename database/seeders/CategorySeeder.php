<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = ['Teknologi', 'Bisnis', 'Sastra', 'Sains', 'Agama', 'Fiksi', 'Sejarah'];

        foreach ($categories as $name) {
            Category::create(['name' => $name]);
        }
    }
}
