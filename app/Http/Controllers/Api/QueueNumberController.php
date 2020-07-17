<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Redis;

class QueueNumber extends Controller
{
    /**
     * @return mixed
     */
    public function leng()
    {
        return Redis::keys('');
    }
}
