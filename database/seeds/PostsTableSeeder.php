<?php

use App\Models\PostCategory;
use Illuminate\Database\Seeder;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @param \Faker\Generator $faker
     * @return void
     */
    public function run(\Faker\Generator $faker)
    {
        //创建文章分类
        PostCategory::create([
            'name' => '校园趣事'
        ]);
        PostCategory::create([
            'name' => '王者荣耀'
        ]);
        PostCategory::create([
            'name' => '其他',
            'sort' => 999,
        ]);
        factory(\App\Models\Post::class, 50)->create([
            'post_category_id' => mt_rand(1, 4),

        ])->each(function ($item) use ($faker) {
            for ($i=1; $i<mt_rand(3, 10); $i++){
                \App\Models\PostComment::create([
                    'content' => $faker->paragraph(),
                    'post_id' => $item->id,
                    'user_id' => 1
                ]);
            }
            \App\Models\PostImage::create([
                'image' => 'http://iph.href.lu/1000x800',
                'sm_image' => 'http://iph.href.lu/80x80',
                'post_id' => $item->id
            ]);
        });
    }
}
