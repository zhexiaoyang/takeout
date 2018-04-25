<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGoodsTable extends Migration 
{
	public function up()
	{
		Schema::create('goods', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('deopt_id')->unsigned()->default(0);
            $table->decimal('price')->unsigned()->default(0);
            $table->integer('shop_id')->unsigned()->default(0);
            $table->integer('cagegory_id')->unsigned()->default(0);
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('goods');
	}
}
