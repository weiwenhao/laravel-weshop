<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => '校园外卖',
        ]);

        Category::create([
            'name' => '水果超市',
        ]);

        Category::create([
            'name' => '电子配件',
        ]);

        Category::create([
            'name' => '二手杂货',
        ]);
    }
}
