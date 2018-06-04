<?php
namespace ezwechat\request;

require_once __DIR__ . '/BaseApi.php';
require_once dirname(__DIR__) . '/lib/wxBizMsgCrypt.php';

class component extends BaseApi{

    private $callback_url;

    private $component_ticket = '';
    private $component_access_token = '';

    public function __construct(){
        parent::__construct();
        $this->callback_url = '';
    }

    public function setCallbackUrl($callback){
        $this->callback_url = $callback;
    }

    private function setComponentVerifyTicket($component_ticket){
        file_put_contents( dirname(__DIR__). '/log/tickets.log', $component_ticket);
        return $this->component_ticket = $component_ticket;
    }

    private function getComponentVerifyTicket(){
        if('' !== $this->component_ticket){
            return $this->component_ticket;
        }elseif(file_exists( dirname(__DIR__). '/log/tickets.log')){
            return file_get_contents( dirname(__DIR__). '/log/tickets.log');
        }
        return ;
    }

    public function parseComponentVerifyTicket($msg_sign, $timeStamp, $nonce, $from_xml){
        $pc = new \WXBizMsgCrypt($this->token, $this->encodingAesKey, $this->getAppId());

        // 第三方收到公众号平台发送的消息
        $msg = '';
        $errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
        if ($errCode == 0) {
            $xml_tree = new DOMDocument();
            $xml_tree->loadXML($msg);
            $array_e = $xml_tree->getElementsByTagName('ComponentVerifyTicket');
            $ticket = $array_e->item(0)->nodeValue;
            $array_s = $xml_tree->getElementsByTagName('CreateTime');
            $createtime = $array_s->item(0)->nodeValue;

            $this->setComponentVerifyTicket($ticket);
        }
        return $this->component_ticket;
    }

    public function getComponentLoginpageLink(){
        $location = sprintf(
                'https://mp.weixin.qq.com/cgi-bin/componentloginpage?component_appid=%s&pre_auth_code=%s&redirect_uri=%s&auth_type=%d',
                $this->appId,
                $this->getPreAuthCode(),
                urlencode( $this->callback_url ),
                1
             );
        return $location;
    }

    public function getComponentBindLink(){
        $location = sprintf(
                'https://mp.weixin.qq.com/safe/bindcomponent?action=bindcomponent&no_scan=1&component_appid=%s&pre_auth_code=%s&redirect_uri=%s&auth_type=%d&biz_appid=%s#wechat_redirect',
                $this->appId,
                $this->getPreAuthCode(),
                urlencode( $this->callback_url ),
                1,
                ''
            );
        return $location;
    }

    private function getComponentAccessToken( ){
        if('' !== $this->component_access_token){
            return $this->component_access_token;
        }
        $params = array(
            'component_appid' =>$this->appId,
            'component_appsecret' => $this->appSecret,
            'component_verify_ticket' => $this->getComponentVerifyTicket()
        );
        $api = sprintf( $this->api_base_url . 'component/api_component_token' );
        $json = $this->api_request_post( $api , $params );
        $this->debug(__METHOD__ . $json);
        if(null!=$json){
            $obj = json_decode($json);
            if(!empty($obj->component_access_token)){
                $this->component_access_token = $obj->component_access_token;
                return $this->component_access_token;
            }
        }
        return ;
    }

    public function getPreAuthCode(){
        $api = sprintf( $this->api_base_url . 'component/api_create_preauthcode?component_access_token=%s', $this->getComponentAccessToken());
        $params = array(
            'component_appid' =>$this->appId,
        );
        $json = $this->api_request_post($api, $params) ;
        $this->debug(__METHOD__ . $json);
        if(null!=$json){
            $obj = json_decode($json);
            if(!empty($obj->pre_auth_code)){
                return $obj->pre_auth_code;
            }
        }
        return ;
    }

    public function getAccessToken($authcode){
        $api = sprintf( $this->api_base_url . 'component/api_query_auth?component_access_token=%s', $this->getComponentAccessToken());
        $params = array(
            'component_appid' =>$this->appId,
            'authorization_code' =>$authcode,
        );
        $json = $this->api_request_post($api, $params) ;
        $this->debug(__METHOD__ . $json);
        if(false !== $json){
            $obj = json_decode($json);
            if(!empty($obj->authorization_info)){
                file_put_contents( dirname(__DIR__). '/log/AuthorizerAccessToke.log', $json."\n", FILE_APPEND);
                $obj->authorization_info->expires_at = time() + $obj->authorization_info->expires_in;
                return $obj->authorization_info;
            }else{
                throw new \Exception();
            }
        }
        return;
    }

    public function refreshAccessToken($authorizer_appid, $authorizer_refresh_token){
        $api = sprintf( $this->api_base_url . 'component/api_authorizer_token?component_access_token=%s', $this->getComponentAccessToken());
        $params = array(
            'component_appid' => $this->appId,
            'authorizer_appid' => $authorizer_appid,
            'authorizer_refresh_token' => $authorizer_refresh_token,
        );
        $json = $this->api_request_post($api, $params) ;
        $this->debug(__METHOD__ . $json);
        if(null!=$json){
            $obj = json_decode($json);
            $obj->expires_at = time() + $obj->expires_in;
            return $obj;
        }
        return ;
    }

    public function getAuthorizerInfo($authorizer_appid){
        $api = sprintf( $this->api_base_url. 'component/api_get_authorizer_info?component_access_token=%s', $this->getComponentAccessToken());
        $params = array(
            'component_appid' =>$this->appId,
            'authorizer_appid' =>$authorizer_appid,
        );
        $json = $this->api_request_post($api, $params) ;
        $this->debug(__METHOD__ . $json);
        if( '' != $json){
            $obj = json_decode($json);
            return $obj;
        }
        return ;
    }


}
