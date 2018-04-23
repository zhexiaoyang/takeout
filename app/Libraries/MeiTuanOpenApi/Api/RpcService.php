<?php

namespace MeiTuanOpenApi\Api;

use MeiTuanOpenApi\Config\Config;
use MeiTuanOpenApi\Protocol\RpcClient;

class RpcService
{
    protected $client;

    public function __construct(Config $config)
    {
        $this->client = new RpcClient($config);
    }
}