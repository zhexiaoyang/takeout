<?php

namespace MeiTuanOpenApi\Api;

use App\Models\Category;
use App\Models\Shop;


/**
 * 店铺服务
 */
class CategoryService extends RpcService
{

    public function create(Category $category)
    {
        $shop = Shop::where(['id' => $category->shop_id])->first();
        $params = [
            "app_poi_code" => $shop->meituan_id,
            "category_code" => $category->id,
            "category_name" => $category->name,
            "sequence" => $category->sort,
        ];
        $result = json_decode($this->client->call("/medicineCat/save", $params), true);
        if ($result && $result['data'] == 'ok')
        {
            $category->meituan_id = $category->id;
            $category->save();
            return true;
        }
        return false;
    }

    public function update($category)
    {
        $shop = Shop::where(['id' => $category->shop_id])->first();
        $params = [
            "app_poi_code" => $shop->meituan_id,
            "category_code" => $category->id,
            "category_name" => $category->name,
            "sequence" => $category->sort,
        ];
        return $this->client->call("/medicineCat/update", $params);
    }

    public function destroy($category)
    {
        $shop = Shop::where(['id' => $category->shop_id])->first();
        $params = [
            "app_poi_code" => $shop->meituan_id,
            "category_code" => $category->id,
        ];
        return $this->client->call("/medicineCat/delete", $params);
    }

    public function lists(Shop $shop)
    {
        $params = [
            "app_poi_code" => $shop->meituan_id,
        ];
        return $this->client->call("/medicineCat/list", $params, 'GET');
    }

    public function destroy2($app_poi_code, $app_medicine_code)
    {
        $params = [
            "app_poi_code" => $app_poi_code,
            'category_code' => $app_medicine_code,
        ];
        return $this->client->call("/medicineCat/delete", $params);
    }


}