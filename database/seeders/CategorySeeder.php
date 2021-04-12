<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = Category::factory()->times(4)->make();

        Category::insert($categories->toArray());
    }
}
