<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 30)->comment('商品名称');
            $table->float('price', 8, 2)->index()->comment('商品价格');
            $table->text('description')->nullable()->comment('商品描述');
            $table->float('promote_price')->nullable()->comment('促销价格');
            $table->timestamp('promote_start_at')->nullable()->index()->comment('促销开始时间');
            $table->timestamp('promote_stop_at')->nullable()->index()->comment('促销结束时间');
            $table->unsignedTinyInteger('sort')->default(100)->index()->comment('权重');
            $table->unsignedTinyInteger('is_on_sale')->default(1)->index()->comment('是否上架');
            $table->unsignedTinyInteger('is_best')->default(0)->index()->comment('是否精品');
            $table->string('image')->comment('商品图片');
            $table->string('sm_image')->comment('商品图片');
            $table->string('mid_image')->comment('商品图片');
            $table->string('big_image')->comment('商品图片');
            $table->unsignedTinyInteger('category_id')->index()->comment('商品所属分类id');
            $table->unsignedSmallInteger('goods_type_id')->nullable()->comment('商品所属类型');
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
        Schema::dropIfExists('goods');
    }
}
