<?php

namespace MeiTuanOpenApi\Api;


/**
 * 店铺服务
 */
class CategoryService extends RpcService
{

    public function create($category)
    {
        $params = [
            "app_poi_code" => $category->shop_id,
            "category_code" => $category->id,
            "category_name" => $category->name,
            "sequence" => $category->sort,
        ];
        return $this->client->call("/medicineCat/save", $params);
    }

    public function update($category)
    {
        $params = [
            "app_poi_code" => $category->shop_id,
            "category_code" => $category->id,
            "category_name" => $category->name,
            "sequence" => $category->sort,
        ];
        return $this->client->call("/medicineCat/update", $params);
    }

}