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

    public function call($action, array $params)
    {

        $params_head = array(
            'timestamp'=>time(),
            'app_id' =>$this->app_id,
        );

        $params = array_merge($params_head, $params);

        $sig = $this->generate_signature($this->api_request_url.$action, $params);

        $url = $this->api_request_url.$action."?sig=".$sig."&".$this->concatParams($params);

        $result = $this->post($url, $params);

        $response = json_decode($result, true);

        return $response;
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

    private function post($url,$param,$type='POST'){

        $ch = curl_init();
        if (stripos($url, "https://") !== FALSE) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_SSLVERSION, 1); //CURL_SSLVERSION_TLSv1
        }
        if (is_string($param)) {
            $strPOST = $param;
        } else {
            $aPOST = [];
            foreach ($param as $key => $val) {
                $aPOST[] = $key . "=" . urlencode($val);
            }
            $strPOST = join("&", $aPOST);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $strPOST);
        $header = array(
            'application/x-www-form-urlencoded',
        );
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        $sContent = curl_exec($ch);
        Log::info("|curl_error:".curl_error($ch)."|response: " . $sContent);
        $aStatus = curl_getinfo($ch);
        curl_close($ch);
        return $sContent;
        if (intval($aStatus["http_code"]) == 200) {
            return $sContent;
        } else {
            return false;
        }

        $log_id = $this->create_uuid();
        Log::info($log_id."|request: " . json_encode($params));
        $ch = curl_init();
        $this_header = array(
            "Content-type: text/html; charset=utf-8"
        );
        curl_setopt ($ch,CURLOPT_HTTPHEADER,$this_header);
        curl_setopt ($ch, CURLOPT_URL, $url);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt ($ch, CURLOPT_NOSIGNAL, 1);
        curl_setopt ($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt ($ch, CURLE_OPERATION_TIMEDOUT, 10);
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
        Log::info($log_id."|curl_error:".curl_error($ch)."|response: " . $response);
        curl_close($ch);
        return $response;
    }
}
