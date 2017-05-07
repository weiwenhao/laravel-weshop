<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddrsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addrs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 5)->comment('真实姓名');
            $table->char('phone', 11)->comment('手机号码');
            $table->char('garden_name', 3)->comment('园地名称');
            $table->char('floor_name', 3)->comment('宿舍楼名称');
            $table->char('number', 3)->comment('门牌号');
            $table->unsignedInteger('user_id')->comment('用户id');
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
        Schema::dropIfExists('addrs');
    }
}
