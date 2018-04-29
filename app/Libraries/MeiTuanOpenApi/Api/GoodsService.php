<?php

namespace MeiTuanOpenApi\Api;


/**
 * 店铺服务
 */
class GoodsService extends RpcService
{

    public function create($good)
    {
        $params = [
            "app_poi_code" => $good->shop_id,
            'app_medicine_code' => $good->deopt->id,
            'upc' => $good->deopt->upc,
            'medicine_no' => $good->deopt->approval,
            'spec' => $good->deopt->spec,
            'price' => $good->price,
            'stock' => $good->stock,
            'category_code' => $good->category->id,
            'category_name' => $good->category->name,
            'is_sold_out' => $good->online,
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
        $params = [
            "app_poi_code" => $good->shop_id,
            'app_medicine_code' => $good->deopt->id,
            'upc' => $good->deopt->upc,
            'medicine_no' => $good->deopt->approval,
            'spec' => $good->deopt->spec,
            'price' => $good->price,
            'stock' => $good->stock,
            'category_code' => $good->category->id,
            'category_name' => $good->category->name,
            'is_sold_out' => $good->online,
            'sequence' => $good->sort,
        ];
        return $this->client->call("/medicine/update", $params);
    }

    public function destroy($good)
    {
        $params = [
            "app_poi_code" => $good->shop_id,
            'app_medicine_code' => $good->deopt->id,
        ];
        return $this->client->call("/medicine/delete", $params);
    }

}