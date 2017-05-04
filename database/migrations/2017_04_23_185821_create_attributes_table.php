<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', '10')->comment('商品属性名称');
            $table->enum('type', ['唯一', '可选'])->comment('商品属性类型');
            $table->string('option_values', 255)->nullable()->comment('商品属性可选值');
            $table->unsignedTinyInteger('type_id')->comment('商品对应类型id');
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
        Schema::dropIfExists('attributes');
    }
}
