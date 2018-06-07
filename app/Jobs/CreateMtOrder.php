<?php

namespace App\Jobs;

use App\Http\Controllers\OrdersController;
use App\Models\MtLog;
use App\Models\OrderLog;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use MeiTuanOpenApi\Api\OrderService;
use MeiTuanOpenApi\Config\Config;

class CreateMtOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $log;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(MtLog $log)
    {
        $this->log = $log;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = json_decode($this->log->request, true);
        $order_id = $data['order_id'];
        $goods_data = json_decode(urldecode($data['detail']), true);
//        $extra_data = json_decode(urldecode($data['extras']), true);
        $shop = \DB::table('shops')->select('id')->where('meituan_id', $data['app_poi_code'])->first();
        $order = \DB::table('orders')->where('order_id',$order_id)->first();
        if (!$order)
        {
            $insert = [
                'order_id' => $data['order_id'],
                'order_id_view' => $data['wm_order_id_view'],
                'shop_id' => $shop->id,
                'recipient_address' => urldecode($data['recipient_address']),
                'recipient_phone' => $data['recipient_phone'],
                'recipient_name' => urldecode($data['recipient_name']),
                'longitude' => $data['longitude'],
                'latitude' => $data['latitude'],
                'total' => $data['total'],
                'original_price' => $data['original_price'],
                'shipping_fee' => $data['shipping_fee'],
                'caution' => urldecode($data['caution']),
                'has_invoiced' => $data['has_invoiced'],
                'invoice_title' => urldecode($data['invoice_title']),
                'taxpayer_id' => isset($data['taxpayer_id'])?$data['taxpayer_id']:'',
                'delivery_time' => $data['delivery_time'],
                'pay_type' => isset($data['pay_type'])?$data['pay_type']:0,
                'day_seq' => isset($data['day_seq'])?$data['day_seq']:0,
                'shipper_phone' => $data['shipper_phone'],
                'is_third_shipping' => isset($data['is_third_shipping'])?$data['is_third_shipping']:0,
                'logistics_code' => isset($data['logistics_code'])?$data['logistics_code']:'',
                'status' => $data['status'],
                'ctime' => $data['ctime'],
                'utime' => $data['utime'],
                'poi_receive_detail' => $data['poi_receive_detail'],
                'created_at' => date("Y-m-d H:i:s"),
                'updated_at' => date("Y-m-d H:i:s"),
            ];
            if ( \DB::table('orders')->insert($insert) )
            {
                $order = \DB::table('orders')->where('order_id',$order_id)->first();

                if ($order && !empty($goods_data))
                {
                    foreach ($goods_data as $v)
                    {
                        $goods = [
                            'order_id' => $order->id,
                            'shop_id' => $shop->id,
                            'third_order_id' => $order_id,
                            'goods_id' => $v['app_food_code'],
                            'good_name' => $v['food_name'],
                            'quantity' => $v['quantity'],
                            'price' => $v['price'],
                            'box_num' => $v['box_num'],
                            'box_price' => $v['box_price'],
                            'created_at' => date("Y-m-d H:i:s"),
                            'updated_at' => date("Y-m-d H:i:s"),
                        ];
                        if (\DB::table('order_details')->insert($goods))
                        {
                            \DB::table('goods')->where(['shop_id' => $shop->id, 'deopt_id' => $v['app_food_code']])->decrement('stock', $v['quantity']);
                        }
                    }

                }
//                if ($order && !empty($extra_data))
//                {
//                    foreach ($extra_data as $v)
//                    {
//                        if (isset($v['remark']))
//                        {
//                            $extra = [
//                                'order_id' => $order->id,
//                                'third_order_id' => $order_id,
//                                'name' => $v['remark'],
//                                'total' => isset($v['reduce_fee'])?$v['reduce_fee']:0,
//                                'pt_price' => isset($v['mt_charge'])?$v['mt_charge']:0,
//                                'price' => isset($v['poi_charge'])?$v['poi_charge']:0,
//                                'created_at' => date("Y-m-d H:i:s"),
//                                'updated_at' => date("Y-m-d H:i:s"),
//                            ];
//                            \DB::table('order_extras')->insert($extra);
//                        }
//                    }
//                }
                // 确认订单

                $server = New OrderService(New Config(env('MT_APPID'),env('MT_SECRET')));
                $server->confirm($order_id);
                $log = new OrderLog;
                $log->order_id = $order->order_id;
                $log->message = '创建订单成功';
                $log->operator = 'system';
                $log->save();
            }
        }
    }
}
