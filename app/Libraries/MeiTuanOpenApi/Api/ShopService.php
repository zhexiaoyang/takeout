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
    public function create_shop($shop)
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
            "third_tag_name" => 'OTC,中药',
//            "pre_book" => $shop->pre_book,
//            "time_select" => $shop->time_select,
//            "app_brand_code" => $shop->app_brand_code,
        ];
        return $this->client->call("/poi/save", $params);
    }

    public function update_shop($shop)
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
        ];
        return $this->client->call("/poi/save", $params);
    }

}