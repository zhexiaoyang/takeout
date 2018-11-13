<?php

namespace App\Http\Requests;

class DeoptRequest extends Request
{
    public function rules()
    {
        switch($this->method())
        {
            // CREATE
            case 'POST':
            {
                return [
                    'name'      => 'required',
                    'approval'  => 'required',
                    'upc'       => 'required',
                    'spec'       => 'required',
                ];
            }
            // UPDATE
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name'       => 'required',
                    'approval'        => 'required',
                    'upc' => 'required',
                ];
            }
            case 'GET':
            case 'DELETE':
            default:
            {
                return [];
            };
        }
    }

    public function messages()
    {
        return [
            'name.required' => '药品名称不能为空',
            'approval.required' => '国药准字号不能为空',
            'upc.required' => '条形码不能为空',
            'spec.required' => '规格不能为空',
        ];
    }
}
