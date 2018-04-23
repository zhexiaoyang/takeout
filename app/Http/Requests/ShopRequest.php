<?php

namespace App\Http\Requests;

class ShopRequest extends Request
{
    public function rules()
    {

//        switch($this->method())
//        {
//            // CREATE
//            case 'POST':
//            {
//                return [
//                    // CREATE ROLES
//                ];
//            }
//            // UPDATE
//            case 'PUT':
//            case 'PATCH':
//            {
//                return [
//                    // UPDATE ROLES
//                ];
//            }
//            case 'GET':
//            case 'DELETE':
//            default:
//            {
//                return [];
//            };
//        }
        return [
            'name' => 'required|between:1,25|unique:shops,name,' . $this->id,
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'pic_url' => 'required',
            'phone' => 'required',
            'standby_tel' => 'required',
            'shipping_fee' => 'required',
            'shipping_time' => 'required',
            'promotion_info' => 'required',
            'open_level' => 'required',
            'is_online' => 'required',
            'invoice_support' => 'required',
            'invoice_min_price' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => '药店名已被占用，请重新填写',
            'name.between' => '药店名必须介于 1 - 25 个字符之间。',
            'name.required' => '药店名不能为空。',
            'phone.required' => '客服电话不能为空。',
            'latitude.required' => '经度不能为空。',
            'longitude.required' => '纬度不能为空。',
            'address.required' => '地址不能为空。',
            'pic_url.required' => 'Logo图片地址不能为空。',
            'standby_tel.required' => '门店电话不能为空。',
            'shipping_fee.required' => '配送费不能为空。',
            'shipping_time.required' => '营业时间不能为空。',
            'promotion_info.required' => '门店公告不能为空。',
            'open_level.required' => '营业状态不能为空。',
            'is_online.required' => '在线状态不能为空。',
            'invoice_support.required' => '是否支持开发票不能为空。',
            'invoice_min_price.required' => '发票最小额不能为空。',
        ];
    }
}
