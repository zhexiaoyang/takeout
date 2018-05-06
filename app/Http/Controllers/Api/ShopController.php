<?php

namespace App\Http\Controllers\Api;

use App\Jobs\CreateMtOrder;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * 门店状态变更回调URL
     * @return mixed
     */
    public function status()
    {
        return $this->response->array(['data' => 'ok']);
    }
}
