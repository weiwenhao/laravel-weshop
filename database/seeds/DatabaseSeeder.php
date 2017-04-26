<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(AdminsTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        //商品填充
        $this->call(GoodsTableSeeder::class);
        $this->call(TypesTableSeeder::class);

        $this->call(OrdersSeeder::class);
        $this->call(shopCartsTableSeeder::class);

        //圈子填充
//        $this->call(PostsTableSeeder::class);
    }
}
