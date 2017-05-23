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
            $table->string('name', 50)->comment('商品名称');
            $table->decimal('price', 8, 2)->index()->comment('商品价格');
            $table->text('description')->nullable()->comment('商品描述'); //text不允许设置默认值
            $table->decimal('promote_price')->default(0.00)->comment('促销价格');
            $table->timestamp('promote_start_at')->nullable()->index()->comment('促销开始时间');
            $table->timestamp('promote_stop_at')->nullable()->index()->comment('促销结束时间');
            $table->unsignedTinyInteger('sort')->default(100)->index()->comment('权重,数字越小越靠前');
            $table->unsignedTinyInteger('is_sale')->default(1)->index()->comment('是否上架');
            $table->unsignedTinyInteger('is_best')->default(0)->index()->comment('是否精品');
            $table->unsignedInteger('buy_count')->default(0)->index()->comment('出售数量');
            $table->string('image')->comment('商品图片 原图');
            $table->string('sm_image')->comment('商品图片 50x50');
            $table->string('mid_image')->comment('商品图片 100x100');
            $table->string('big_image')->comment('商品图片 300x300');
            $table->unsignedTinyInteger('category_id')->index()->comment('商品所属分类id');
            $table->unsignedSmallInteger('type_id')->default(0)->comment('商品所属类型');
            $table->unsignedTinyInteger('is_deleted')->default(0)->index()->comment('是否被删除');
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
