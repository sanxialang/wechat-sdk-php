<?php
namespace ezwechat\request;

require_once 'BaseApi.php';

class setting extends BaseApi{

    public function __construct($access_token){
        parent::__construct();
        $this->authorizer_access_token = $access_token;
    }

    /**
     * 获取公众号的自动回复规则
     *
     */
    public function get_current_autoreply_info(){
        $api = sprintf( $this->api_base_url . 'get_current_autoreply_info?access_token=%s', $this->getAuthorizer_access_token());

        $json = $this->api_request_get($api, null);
        $this->debug(__METHOD__ . $json);
        if( '' != $json){
            $obj = json_decode($json);
            return $obj;
        }
        return;

    }

    /**
     * 获取微信服务器IP地址
     *
     */
    public function getcallbackip(){
        $api = sprintf( $this->api_base_url . 'getcallbackip?access_token=%s', $this->getAuthorizer_access_token());

        $json = $this->api_request_get($api, null);
        $this->debug(__METHOD__ . $json);
        if( '' != $json){
            $obj = json_decode($json);
            return $obj;
        }
        return;

    }

}
