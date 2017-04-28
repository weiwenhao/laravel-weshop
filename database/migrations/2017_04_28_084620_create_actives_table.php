<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActivesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('actives', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 10)->comment('活动名称');
            $table->longText('content')->nullable()->comment('活动详情');
            $table->string('url', 15)->comment('对应url,对上述活动名称的合理翻译即可');
            $table->string('image', 255)->comment('封面');
            $table->unsignedInteger('sort')->default(100)->comment('排名,从小到大 asc排序');
            $table->unsignedTinyInteger('is_show')->default(0)->comment('是否显示');
            $table->unsignedTinyInteger(('is_content'))->default(0)->comment('是否存在活动详情');
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
        Schema::dropIfExists('actives');
    }
}
