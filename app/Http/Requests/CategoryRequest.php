<?php

namespace App\Http\Requests;

class CategoryRequest extends Request
{
    public function rules()
    {
        return [
            'sync' => 'required',
            'shop_id' => 'required',
            'name' => 'required',
            'sort' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'sync.required' => '同步平台不能为空。',
            'shop_id.required' => '门店不能为空。',
            'name.required' => '名称不能为空。',
            'sort.required' => '排序不能为空。',
        ];
    }
}
