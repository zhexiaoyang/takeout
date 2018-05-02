<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function create()
    {
        return $this->response->array(['data' => 'ok']);
    }

    public function cancel()
    {
        return $this->response->array(['data' => 'ok']);
    }
}
