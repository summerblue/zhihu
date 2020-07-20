<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = factory(Category::class)->times(4)->make();

        Category::insert($categories->toArray());
    }
}
