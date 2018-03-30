<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_attributes', function (Blueprint $table) {
            $table->increments('id'); //必要,用于确定一条属性,在商品库存,购物车等地方很有用
            $table->unsignedInteger('goods_id')->index()->comment('商品id');
            $table->unsignedInteger('attribute_id')->index()->comment('属性id');
            $table->string('attribute_value')->comment('属性值');
            $table->unique(['goods_id', 'attribute_id', 'attribute_value']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('goods_attributes');
    }
}
