<?php

namespace App\Http\Requests;

class GoodRequest extends Request
{
    public function rules()
    {
        return [
            'sync' => 'required',
            'shop_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'online' => 'required',
            'sort' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'sync.required' => '同步平台不能为空。',
            'shop_id.required' => '门店不能为空。',
            'price.required' => '价格不能为空。',
            'stock.required' => '库存不能为空。',
            'online.required' => '上下架状态。',
            'sort.required' => '排序不能为空。',
        ];
    }
}
