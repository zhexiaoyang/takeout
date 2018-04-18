<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeoptsTable extends Migration 
{
	public function up()
	{
		Schema::create('deopts', function(Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('category');
            $table->string('unit');
            $table->decimal('price');
            $table->string('spec');
            $table->text('description');
            $table->string('approval');
            $table->integer('is_otc')->integer()->unsigned()->default(0);
            $table->string('upc');
            $table->integer('mt_id')->unsigned()->default(0);
            $table->integer('status')->unsigned()->default(1);
            $table->text('picture');
            $table->string('common_name');
            $table->string('company');
            $table->string('brand');
            $table->text('yfyl');
            $table->text('syz');
            $table->text('syrq');
            $table->text('cf');
            $table->text('blfy');
            $table->text('jj');
            $table->text('zysx');
            $table->text('ypxhzy');
            $table->text('etyy');
            $table->text('rsybr');
            $table->text('lnryy');
            $table->string('xz');
            $table->string('bz');
            $table->string('jx');
            $table->string('zc');
            $table->string('ylzy');
            $table->string('yxq');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('deopts');
	}
}
