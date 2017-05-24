<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_news', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('from_user_id')->index()->comment('消息的创建方');
            $table->unsignedInteger('obj_user_id')->index()->comment('消息的接收方');
            $table->unsignedInteger('post_id')->index()->comment('对应的帖子id');
            $table->unsignedTinyInteger('type')->index()->comment('消息类型  1->评论, 2->评论回复 4->点赞 3->加精 4->置顶');
            $table->string('content', 100)->default('')->comment('消息内容');
            $table->timestamp('read_at')->index()->nullable()->comment('消息被读取的时间');
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
        Schema::dropIfExists('post_news');
    }
}
