<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopDetailsTable extends Migration 
{
	public function up()
	{
		Schema::create('shop_details', function(Blueprint $table) {
            $table->increments('id');
            $table->integer('shop_id')->unsigned()->default(0);
            $table->string('opening_bank');
            $table->string('username');
            $table->string('account_number');
            $table->integer('is_invoice')->unsigned()->default(0);
            $table->integer('type')->unsigned()->default(0);
            $table->string('name');
            $table->string('number');
            $table->integer('coefficient')->unsigned()->default(15);
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('shop_details');
	}
}
