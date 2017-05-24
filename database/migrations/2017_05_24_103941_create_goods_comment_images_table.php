<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsCommentImagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('goods_comment_images', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sm_image')->comment('评价缩略图');
            $table->string('image')->comment('原图');
            $table->unsignedInteger('goods_comment_id')->index();
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
        Schema::dropIfExists('goods_comment_images');
    }
}
