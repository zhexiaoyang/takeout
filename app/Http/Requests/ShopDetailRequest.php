<?php

namespace App\Http\Requests;

class ShopDetailRequest extends Request
{
    public function rules()
    {

        $route_name = Request::route()->getName();
        if ($route_name == 'shop_details.update') {
            return [
                'opening_bank' => 'required',
                'username' => 'required',
                'account_number' => 'required',
                'is_invoice' => 'required',
            ];
        }
        return [
            'shop_id' => 'required|unique:shop_details,shop_id,' . $this->shop_id,
            'opening_bank' => 'required',
            'username' => 'required',
            'account_number' => 'required',
            'is_invoice' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'shop_id.unique' => '药店信息已存在',
            'shop_id.required' => '药店信息错误。',
            'opening_bank.required' => '开户行不能为空。',
            'username.required' => '户名不能为空。',
            'account_number.required' => '打款账号不能为空。',
            'is_invoice.required' => '是否开发票不能为空。',
        ];
    }
}
