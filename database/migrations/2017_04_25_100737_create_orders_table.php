<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->char('order_id', 16);
            $table->string('remarks', 50)->nullable()->comment('订单备注');
            $table->char('user_id', 28)->comment('用户的openid');
            //地址用户信息
            $table->string('name', 5)->comment('真实姓名');
            $table->char('phone', 11)->comment('手机号码');
            $table->char('garden_name', 3)->comment('园地名称');
            $table->char('floor_name', 3)->index()->comment('宿舍楼名称');
            $table->char('number', 3)->comment('门牌号');

            $table->unsignedTinyInteger('is_pay')->default(0)->index()->comment('是否支付');
            $table->decimal('total_price')->comment('订单总额');
            $table->timestamps();
        });

        //订单商品表
        Schema::create('order_goods', function (Blueprint $table) {
            $table->increments('id')->comment('订单商品id');
            $table->char('order_id', 14)->index()->comment('订单id');
            $table->unsignedInteger('goods_id')->index()->comment('商品id');
            $table->string('goods_attribute_ids', 30)->nullable()->comment('商品属性id,多个id之间逗号分隔,只需要可选属性');
            $table->unsignedTinyInteger('shop_number')->comment('购买数量');
            $table->decimal('shop_price')->comment('购买单价');
            $table->unsignedTinyInteger('status')->default(0)->index()->comment('订单商品状态 0->未受理  1->已受理,2->已经完成,3->已关闭'); //
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
        Schema::dropIfExists('orders');
        Schema::dropIfExists('order_goods');
    }
}
