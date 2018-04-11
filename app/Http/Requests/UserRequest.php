<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $id = isset($this->user->id)?$this->user->id:0;
        return [
            'name' => 'required|between:3,25|regex:/^[A-Za-z0-9\-\_]+$/|unique:users,name,' . $id,
            'phone' => 'required|regex:/^1[34578][0-9]{9}$/|unique:users,phone,' . $id,
            'email' => 'email|unique:users,email,' . $id,
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => '用户名已被占用，请重新填写',
            'name.regex' => '用户名只支持中英文、数字、横杆和下划线。',
            'name.between' => '用户名必须介于 3 - 25 个字符之间。',
            'name.required' => '用户名不能为空。',
            'phone.required' => '电话不能为空。',
            'phone.regex' => '电话格式不正确。',
            'phone.unique' => '电话已被占用，请重新填写',
            'email.email' => '邮箱格式不正确。',
            'email.unique' => '邮箱已被占用，请重新填写',
        ];
    }
}