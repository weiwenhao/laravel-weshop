<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('numbers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('goods_id')->index()->comment('商品id');
            $table->string('goods_attribute_ids', 50)->default('')->index()->comment('商品属性ids,升序排列');
            $table->unsignedInteger('number')->default(9999)->comment('该商品,在该属性下的库存量,默认设置为9999');
            $table->decimal('price')->nullable()->comment('该商品在该属性下的价格,默认为NULL,则使用goods表中的价格');
            $table->unique(['goods_id', 'goods_attribute_ids']); //加一个联合索引,如果使用到的话就不会出现 死锁的情况
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
        Schema::dropIfExists('numbers');
    }
}
