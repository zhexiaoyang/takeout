<?php

namespace MeiTuanOpenApi\Protocol;

use MeiTuanOpenApi\Config\Config;
use Log;

class RpcClient
{

    private $app_id;
    private $app_secret;
    private $api_request_url;

    public function __construct(Config $config)
    {
        $this->app_id = $config->get_app_id();
        $this->app_secret = $config->get_app_secret();
        $this->api_request_url = $config->get_request_url() . "/api/v1";
    }

    public function call($action, array $params, $type='POST')
    {

        $params_head = array(
            'timestamp'=>time(),
            'app_id' =>$this->app_id,
        );

        $params = array_merge($params_head, $params);

        $sig = $this->generate_signature($this->api_request_url.$action, $params);

        $url = $this->api_request_url.$action."?sig=".$sig."&".$this->concatParams($params);

        return $this->post($url, $params, $type);
    }

    private function generate_signature($action, $params) {
        $params = $this->concatParams($params);
        $str = $action.'?'.$params.$this->app_secret;
        return md5($str);
    }

    private function concatParams($params) {
        ksort($params);
        $pairs = array();
        foreach($params as $key=>$val) {
            array_push($pairs, $key . '=' . $val);
        }
        return join('&', $pairs);
    }

    private function create_uuid()
    {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    private function post($url,$params,$type='POST'){
        $log_id = $this->create_uuid();
        Log::alert($log_id."|request: " . json_encode($params, JSON_UNESCAPED_UNICODE));
        $ch = curl_init();
        $this_header = array(
            "Content-type: text/html; charset=utf-8"
        );
        curl_setopt ($ch,CURLOPT_HTTPHEADER,$this_header);
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt ($ch, CURLOPT_TIMEOUT, 10);
        switch ($type){
            case "GET" : curl_setopt($ch, CURLOPT_HTTPGET, true);break;
            case "POST": curl_setopt($ch, CURLOPT_POST,true);
            curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($params));break;
            case "PUT" : curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS,$params);break;
            case "DELETE":curl_setopt ($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_POSTFIELDS,$params);break;
        }
        $response = curl_exec($ch);
//        dd($response);
        Log::alert($log_id."|curl_error:".curl_error($ch)."|response: " . $response);
        curl_close($ch);
        return $response;
    }
}
