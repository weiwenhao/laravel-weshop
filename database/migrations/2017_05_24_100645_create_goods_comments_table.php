<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content', 300)->comment('评价详情');
            $table->unsignedInteger('goods_id')->index()->comment('商品id');
            $table->string('goods_attributes', '100')->comment('商品属性信息聚合');
            $table->unsignedTinyInteger('level')->comment('评论等级');
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
        Schema::dropIfExists('goods_comments');
    }
}
