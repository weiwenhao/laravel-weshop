<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 10)->unique()->comment('分类名称');
            $table->unsignedTinyInteger('sort')->default(100)->index()->comment('权重');
            $table->unsignedTinyInteger('is_show')->default(1)->index()->comment('是否显示在前台');
            $table->string('logo', 255)->default('')->comment('分类logo');
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
        Schema::dropIfExists('categories');
    }
}
