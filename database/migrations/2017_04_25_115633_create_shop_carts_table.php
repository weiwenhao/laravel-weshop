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
            $table->char('user_id', 28)->comment('用户的微信open_id');
            $table->unsignedInteger('goods_id')->comment('商品id');
            $table->string('goods_attribute_ids')->nullable()->comment('商品属性id,只需要可选属性');
            $table->unsignedInteger('number')->comment('该商品的数量');
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
