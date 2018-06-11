<?php
namespace ezwechat\request;

require_once 'BaseApi.php';

class open extends BaseApi{

    /**
     *
     */
    public function bind($access_token, $appId, $open_appId){
        $api = sprintf( $this->api_base_url . 'open/bind?access_token=%s', $access_token);
        $params = array(
            'appid' =>$appId,
            'open_appid' =>$open_appId,
        );

        $json = $this->api_request_post($api, $params) ;
        $this->debug(__METHOD__ . $json);
        if( '' != $json){
            $obj = json_decode($json);
            return $obj;
        }
        return;

    }

    /**
     * 获取公众号/小程序所绑定的开放平台帐号
     */
    public function getList($access_token, $appId){
        $api = sprintf( $this->api_base_url . 'open/get?access_token=%s', $access_token);
        $params = array(
            'appid' =>$appId,
        );

        $json = $this->api_request_post($api, $params) ;
        $this->debug(__METHOD__ . $json);
        if( '' != $json){
            $obj = json_decode($json);
            return $obj;
        }
        return;

    }

}
