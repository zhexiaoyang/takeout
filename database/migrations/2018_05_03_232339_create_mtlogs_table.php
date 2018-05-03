<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMtLogsTable extends Migration 
{
	public function up()
	{
		Schema::create('mt_logs', function(Blueprint $table) {
            $table->increments('id');
            $table->string('api');
            $table->text('request');
            $table->text('response');
            $table->integer('type')->unsigned()->default(0);
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('mt_logs');
	}
}
