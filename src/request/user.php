<?php
namespace ezwechat\request;

require_once __DIR__ . '/BaseApi.php';

class user extends BaseApi{

    public function __construct($access_token){
        parent::__construct();
        $this->authorizer_access_token = $access_token;
    }

    public function getUserList($next_openid){
        $api = sprintf( $this->api_base_url . 'user/get?access_token=%s&next_openid=%s', $this->authorizer_access_token , $next_openid);
        $json = $this->api_request_get($api) ;
        $this->debug(__METHOD__ . $json);
        if( '' != $json){
            $obj = json_decode($json);
            return $obj;
        }
        return;
    }

    public function getUserInfo($openid){
        $api = sprintf( $this->api_base_url . 'user/info?access_token=%s&openid=%s&lang=zh_CN', $this->authorizer_access_token, $openid);
        $json = $this->api_request_get($api) ;
        $this->debug(__METHOD__ . $json);
        if( '' != $json){
            $obj = json_decode($json);
            return $obj;
        }
        return;
    }
}
