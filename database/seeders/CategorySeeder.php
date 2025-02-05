<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Groceries',
            'Leisure',
            'Electronics',
            'Utilities',
            'Clothing',
            'Health',
            'Others',
        ];

        foreach ($categories as $category) {
            Category::create(['name' => $category]);
        }
    }
}
