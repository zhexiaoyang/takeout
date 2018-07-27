<?php

namespace MeiTuanOpenApi\Config;

class Config
{
    private $app_id;
    private $app_secret;
    private $request_url = "https://waimaiopen.meituan.com";

    public function __construct($app_id, $app_secret)
    {
        $this->app_id = $app_id;
        $this->app_secret = $app_secret;
    }

    public function get_app_id()
    {
        return $this->app_id;
    }

    public function get_app_secret()
    {
        return $this->app_secret;
    }

    public function get_request_url()
    {
        return $this->request_url;
    }
}