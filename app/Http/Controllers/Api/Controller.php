<?php

namespace App\Http\Controllers\Api;

use App\Models\MtLog;
use Illuminate\Http\Request;
use Dingo\Api\Routing\Helpers;
use App\Http\Controllers\Controller as BaseController;

class Controller extends BaseController
{
    use Helpers;

    public $log;

    public function __construct(MtLog $log)
    {
        $this->log = $log;

        if (!empty($_POST) || !empty($_GET))
        {
            $this->log->request = json_encode(empty($_POST)?$_GET:$_POST,JSON_UNESCAPED_UNICODE);
            $this->log->type = 2;
        }
    }
}