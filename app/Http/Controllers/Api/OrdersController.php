<?php

namespace App\Http\Controllers\Api;

use App\Jobs\CreateMtOrder;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function create()
    {
        $result = ['data' => 'ok'];
        $this->log->api = 'api/orderCreate';
        $this->log->response = json_encode($result);
        $this->log->save();
        dispatch(new CreateMtOrder($this->log));
        return $this->response->array($result);
    }

    public function cancel()
    {
        return $this->response->array(['data' => 'ok']);
    }
}
