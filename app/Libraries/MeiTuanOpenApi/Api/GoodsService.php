<?php

namespace MeiTuanOpenApi\Api;

use App\Models\Shop;


/**
 * 店铺服务
 */
class GoodsService extends RpcService
{

    public function create($good)
    {
        $shop = Shop::where(['id' => $good->shop_id])->first();
        $params = [
            "app_poi_code" => $shop->meituan_id,
            'app_medicine_code' => $good->deopt->id,
            'upc' => $good->deopt->upc,
            'medicine_no' => $good->deopt->approval,
            'spec' => $good->deopt->spec,
            'price' => $good->price,
            'stock' => $good->stock,
            'category_code' => $good->category->id,
            'category_name' => $good->category->name,
            'is_sold_out' => 0,
            'sequence' => $good->sort,
        ];
        $result = json_decode($this->client->call("/medicine/save", $params), true);

        if ($result && $result['data'] == 'ok')
        {
            $good->meituan_id = $good->id;
            $good->save();
            return true;
        }

        return false;
    }

    public function update($good)
    {
        $shop = Shop::where(['id' => $good->shop_id])->first();
        $params = [
            "app_poi_code" => $shop->meituan_id,
            'app_medicine_code' => $good->deopt->id,
            'upc' => $good->deopt->upc,
            'medicine_no' => $good->deopt->approval,
            'spec' => $good->deopt->spec,
            'price' => $good->price,
            'stock' => $good->stock,
            'category_code' => $good->category->id,
            'category_name' => $good->category->name,
            'is_sold_out' => $good->online?0:1,
            'sequence' => $good->sort,
        ];
        return $this->client->call("/medicine/update", $params);
    }

    public function destroy($good)
    {
        $shop = Shop::where(['id' => $good->shop_id])->first();
        $params = [
            "app_poi_code" => $shop->meituan_id,
            'app_medicine_code' => $good->deopt->id,
        ];
        return $this->client->call("/medicine/delete", $params);
    }

    public function destroy2($app_poi_code, $app_medicine_code)
    {
        $params = [
            "app_poi_code" => $app_poi_code,
            'app_medicine_code' => $app_medicine_code,
        ];
        return $this->client->call("/medicine/delete", $params);
    }

    public function syncStock($good, $stock)
    {
        $res = $this->upStock($good, $stock);
        $data = json_decode($res, true);
        if ($data && $data['data'] == 'ok')
        {
            return true;
        }
        return false;
    }

    public function syncPriceStock($good, $stock, $price)
    {
        $res = $this->updatePriceStock($good, $stock, $price);
        $data = json_decode($res, true);
        if ($data && $data['data'] == 'ok')
        {
            return true;
        }
        return false;
    }

    public function updatePriceStock($good, $stock, $price)
    {
        $shop = Shop::where(['id' => $good->shop_id])->first();
        $params = [
            "app_poi_code" => $shop->meituan_id,
            'app_medicine_code' => $good->deopt->id,
            'stock' => $stock,
            'price' => $price
        ];
        return $this->client->call("/medicine/update", $params);
    }

    public function upStock($good, $stock)
    {
        $shop = Shop::where(['id' => $good->shop_id])->first();
        $data = [
            "app_medicine_code" => $good->deopt->id,
            "app_poi_code" => $shop->meituan_id,
            "stock" => $stock
        ];
        $params = [
            "app_poi_code" => $shop->meituan_id,
            "medicine_data" => json_encode([$data])
        ];
        return $this->client->call("/medicine/stock", $params);
    }

    public function lists(Shop $shop)
    {
        $params = [
            "app_poi_code" => $shop->meituan_id,
        ];
        return $this->client->call("/medicine/list", $params, 'GET');
    }


    public function online($good)
    {
        $shop = Shop::where(['id' => $good->shop_id])->first();
        $params = [
            "app_poi_code" => $shop->meituan_id,
            'app_medicine_code' => $good->deopt->id,
            'category_code' => $good->category->id,
            'category_name' => $good->category->name,
            'is_sold_out' => 0,
        ];
        return $this->client->call("/medicine/update", $params);
    }

}