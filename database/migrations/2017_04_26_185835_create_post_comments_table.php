<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_comments', function (Blueprint $table) {
            $table->increments('id');
            $table->string('content', 255)->comment('评论内容');
            $table->unsignedInteger('post_id')->comment('评论的目标文章id');
            $table->char('user_id', 28)->comment('评论用户id');
            $table->char('obj_user_id', 28)->nullable()->comment('评论的目标id,如果为NULL则是对文章的评论');
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
        Schema::dropIfExists('post_comments');
    }
}
