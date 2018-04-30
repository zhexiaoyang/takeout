<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration 
{
	public function up()
	{
		Schema::create('orders', function(Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('order_id')->default(0)->comment('订单ID');
            $table->bigInteger('wm_order_id_view')->default(0)->comment('订单展示ID');
            $table->string('app_poi_code')->comment('APP方商家ID');
            $table->string('wm_poi_name')->comment('美团商家名称');
            $table->string('wm_poi_address')->comment('美团商家地址');
            $table->string('wm_poi_phone')->comment('美团商家电话');
            $table->string('recipient_address')->comment('收件人地址');
            $table->string('recipient_phone')->comment('收件人电话，请兼容13812345678和13812345678_123456两种号码格式，以便对接隐私号订单，最多不超过20位');
            $table->string('recipient_name')->comment('收件人姓名（若用户没有填写姓名，此字段默认为空。可在开发者中心订阅是否用“美团客人”填充此字段）');
            $table->decimal('shipping_fee')->default(0)->comment('门店配送费');
            $table->decimal('total')->default(0)->comment('总价');
            $table->decimal('original_price')->default(0)->comment('原价');
            $table->string('caution')->comment('忌口或备注');
            $table->string('shipper_phone')->comment('送餐员电话');
            $table->integer('status')->default(0)->comment('订单状态');
            $table->integer('city_id')->default(0)->comment('城市ID（目前暂时用不到此信息）');
            $table->integer('has_invoiced')->default(0)->comment('是否开发票');
            $table->string('invoice_title')->comment('发票抬头');
            $table->string('taxpayer_id')->comment('纳税人识别号，该信息默认不推送，如有需求可在开发者中心订阅');
            $table->integer('ctime')->default(0)->comment('创建时间');
            $table->integer('utime')->default(0)->comment('更新时间');
            $table->integer('delivery_time')->default(0)->comment('用户预计送达时间，“立即送达”时为0');
            $table->integer('is_third_shipping')->default(0)->comment('是否是第三方配送平台配送（0：否；1：是）');
            $table->integer('pay_type')->default(0)->comment('支付类型（1：货到付款；2：在线支付）');
            $table->integer('pick_type')->default(0)->comment('取餐类型（0：普通取餐；1：到店取餐）该信息默认不推送，如有需求可在开发者中心订阅');
            $table->double('latitude')->default(0)->comment('实际送餐地址纬度');
            $table->double('longitude')->default(0)->comment('实际送餐地址经度');
            $table->integer('day_seq')->default(0)->comment('门店当天的推单流水号，该信息默认不推送，如有需求可在开发者中心订阅');
            $table->boolean('is_favorites')->comment('用户是否收藏此门店（true，false），该信息默认不推送，如有需求可在开发者中心订阅');
            $table->boolean('is_poi_first_order')->comment('用户是否第一次在此门店点餐（true，false），该信息默认不推送，如有需求可在开发者中心订阅');
            $table->integer('dinners_number')->default(0)->comment('用餐人数，该信息默认不推送，如有需求可在开发者中心订阅');
            $table->string('logistics_code')->comment('订单配送方式，该信息默认不推送，如有需求可在开发者中心订阅');
            $table->timestamps();
        });
	}

	public function down()
	{
		Schema::drop('orders');
	}
}
