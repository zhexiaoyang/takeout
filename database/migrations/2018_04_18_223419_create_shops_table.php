<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopsTable extends Migration 
{
	public function up()
	{
		Schema::create('shops', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('address');
            $table->double('latitude', 15,  8)->unsigned()->default(0);
            $table->double('longitude', 15,  8)->unsigned()->default(0);
            $table->string('pic_url');
            $table->string('pic_url_large');
            $table->string('phone');
            $table->string('standby_tel');
            $table->decimal('shipping_fee', 8, 2)->unsigned()->default(0);
            $table->string('shipping_time');
            $table->string('promotion_info');
            $table->integer('open_level')->unsigned()->default(0);
            $table->integer('is_online')->unsigned()->default(0);
            $table->integer('invoice_support')->unsigned()->default(0);
            $table->integer('invoice_min_price')->unsigned()->default(0);
            $table->string('invoice_description');
            $table->string('third_tag_name');
            $table->integer('pre_book')->unsigned()->default(0);
            $table->integer('time_select')->unsigned()->default(0);
            $table->string('app_brand_code');
            $table->integer('mt_type_id')->unsigned()->default(0);
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('shops');
	}
}
