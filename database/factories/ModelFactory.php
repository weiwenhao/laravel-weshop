<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});


//商品测试数据插入
$factory->define(App\Models\Goods::class, function (Faker\Generator $faker) {
    return [
        'name' => '测试商品插入',
        'price' => '99.99',
        'image' => 'http://iph.href.lu/1000x1000',
        'sm_image' => 'http://iph.href.lu/50x40',
        'mid_image' => 'http://iph.href.lu/200x150',
        'big_image' => 'http://iph.href.lu/500x400',
        'category_id' => 1,
    ];
});
