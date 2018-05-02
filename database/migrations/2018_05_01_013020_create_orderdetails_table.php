<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderDetailsTable extends Migration 
{
	public function up()
	{
		Schema::create('order_details', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('order_id')->default(0)->commit('订单ID');
            $table->bigInteger('third_order_id')->default(0)->comment('第三方订单ID');
            $table->integer('app_food_code')->default(0)->comment('商品ID');
            $table->string('food_name')->comment('狗不理');
            $table->string('sku_id')->comment('SKUID');
            $table->integer('quantity')->default(0)->comment('商品数量');
            $table->decimal('price')->default(0)->comment('此字段默认为活动折扣后价格，可在开发者中心订阅是否替换为原价');
            $table->integer('box_num')->default(0)->comment('餐盒数量');
            $table->decimal('box_price')->default(0)->comment('餐盒价格');
            $table->integer('unit')->default(0)->comment('单位');
            $table->decimal('food_discount')->default(0)->comment('菜品折扣，只是美团商家、APP方配送的门店才会设置，默认为1。折扣值不参与总价计算。开放平台1.0.3 新增');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('order_details');
	}
}
