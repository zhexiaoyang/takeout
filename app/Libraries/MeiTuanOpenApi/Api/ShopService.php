<?php

namespace MeiTuanOpenApi\Api;

use App\Models\Shop;

/**
 * 店铺服务
 */
class ShopService extends RpcService
{
    /** 创建店铺基本信息
     * @param $shop_id 店铺Id
     * @param $properties 店铺属性
     * @return mixed
     */
    public function create_shop(Shop $shop)
    {
        $params = [
            "app_poi_code" => $shop->id,
            "name" => $shop->name,
            "address" => $shop->address,
            "latitude" => $shop->latitude,
            "longitude" => $shop->longitude,
            "pic_url" => $shop->pic_url,
            "phone" => $shop->phone,
            "standby_tel" => $shop->standby_tel,
            "shipping_fee" => $shop->shipping_fee,
            "shipping_time" => $shop->shipping_time,
            "promotion_info" => $shop->promotion_info,
            "open_level" => $shop->open_level,
            "is_online" => $shop->is_online,
            "invoice_support" => $shop->invoice_support,
            "invoice_min_price" => $shop->invoice_min_price,
//            "invoice_description" => $shop->invoice_description,
            "third_tag_name" => 'OTC',
//            "pre_book" => $shop->pre_book,
//            "time_select" => $shop->time_select,
            "mt_type_id" => 179,
        ];

        return $this->client->call("/poi/save", $params);
    }

    public function upArea(Shop $shop)
    {
        $params = [
            'app_poi_code' => $shop->id,
            'app_shipping_code' => 1,
            'type' => 1,
            'area' => json_encode([['x' => ($shop->latitude*1000000 + 1000), 'y' => ($shop->longitude*1000000 +1000)], ['x' => ($shop->latitude*1000000 + 1000), 'y' => ($shop->longitude*1000000 -1000)], ['x' => ($shop->latitude*1000000 - 1000), 'y' => ($shop->longitude*1000000 - 1000)], ['x' => ($shop->latitude*1000000 - 1000), 'y' => ($shop->longitude*1000000 + 1000)]]),
            'min_price' => $shop->min_price,
            'shipping_fee' => $shop->shipping_fee
        ];
        return $this->client->call("/shipping/save", $params);
    }

    public function update_shop(Shop $shop)
    {
        $params = [
            "app_poi_code" => $shop->meituan_id,
//            "app_poi_code" => 't_3Wp0e1dv7T', 
            "name" => $shop->name,
            "address" => $shop->address,
            "latitude" => $shop->latitude,
            "longitude" => $shop->longitude,
            "pic_url" => $shop->pic_url,
            "phone" => $shop->phone,
            "standby_tel" => $shop->standby_tel,
            "shipping_fee" => $shop->shipping_fee,
            "shipping_time" => $shop->shipping_time,
            "promotion_info" => $shop->promotion_info,
            "open_level" => $shop->open_level,
            "is_online" => $shop->is_online,
            "invoice_support" => $shop->invoice_support,
            "invoice_min_price" => $shop->invoice_min_price,
            "third_tag_name" => 'OTC',
            "mt_type_id" => 179,
        ];
        return $this->client->call("/poi/save", $params);
    }

    public function shop_info($shop_ids)
    {

        $params = [
            "app_poi_codes" => $shop_ids
        ];
        return $this->client->call("/poi/mget", $params, 'GET');
    }

    public function shop_list()
    {

        $params = [];
        return $this->client->call("/poi/getids", $params, 'GET');
    }



    public function open(Shop $shop)
    {
        $params = [
            "app_poi_code" => $shop->meituan_id,
        ];
        return $this->client->call("/poi/open", $params);
    }

    public function close(Shop $shop)
    {
        $params = [
            "app_poi_code" => $shop->meituan_id,
        ];
        return $this->client->call("/poi/close", $params);
    }

}