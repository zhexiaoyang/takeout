<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration 
{
	public function up()
	{
		Schema::create('categories', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->integer('sort')->unsigned();
            $table->integer('shop_id')->unsigned();
            $table->integer('ele_id')->unsigned();
            $table->integer('baidu_id')->unsigned();
            $table->integer('meituan_id')->unsigned();
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('categories');
	}
}
