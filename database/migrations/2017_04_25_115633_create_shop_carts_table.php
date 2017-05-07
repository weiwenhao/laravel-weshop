<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_carts', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->comment('用户id');
            $table->unsignedInteger('goods_id')->comment('商品id');
            $table->string('goods_attribute_ids')->default('')->comment('商品属性id,只需要可选属性');
            $table->unsignedInteger('shop_number')->comment('购买的的数量');
            $table->unique(['user_id', 'goods_id', 'goods_attribute_ids']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shop_carts');
    }
}
