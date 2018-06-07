<?php
namespace ezwechat\request;

require_once dirname(__DIR__) . '/lib/wxBizMsgCrypt.php';

class BaseApi{
    protected $debug_mode = false;

    protected $appId ;
    protected $appSecret;
    protected $token ;
    protected $encodingAesKey ;
    protected $authorizer_access_token ;

    protected $api_base_url = 'https://api.weixin.qq.com/cgi-bin/';

    public function __construct(){
	$config = require_once __DIR__ . '/../config.php';
	$this->appId = $config['appId'];
	$this->appSecret = $config['appSecret'];
	$this->token = $config['token'];
	$this->encodingAesKey = $config['encodingAesKey'];
    }

    public function getAppId(){
        return $this->appId;
    }

    public function getAuthorizer_access_token(){
        return $this->authorizer_access_token;
    }

    protected function debug($info){
        if($this->debug_mode)
            var_dump($info);
            
    }

    /*
     * 加密消息体
     */
    public function encryptMsg($text, $timeStamp, $nonce){
        $pc = new \WXBizMsgCrypt($this->token, $this->encodingAesKey, $this->getAppId());

        // 第三方收到公众号平台发送的消息
        $msg = '';
        $errCode = $pc->encryptMsg($text, $timeStamp, $nonce, $msg);
	if($errCode == 0)
	    return $msg;
        return '';
    }

    /*
     * 解密消息体
     */
    public function decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml){
        $pc = new \WXBizMsgCrypt($this->token, $this->encodingAesKey, $this->getAppId());

        // 第三方收到公众号平台发送的消息
        $msg = '';
        $errCode = $pc->decryptMsg($msg_sign, $timeStamp, $nonce, $from_xml, $msg);
        return array($errCode, $msg);
    }

    public function xml_to_json($source) { 
        libxml_disable_entity_loader(true);

        if(is_file($source)){ //传的是文件，还是xml的string的判断 
            $xml_array=simplexml_load_file($source); 
        }else{ 
            $xml_array= json_decode(json_encode(simplexml_load_string($source, 'SimpleXMLElement', LIBXML_NOCDATA))); 
        } 
        return $xml_array;
    } 

    protected function api_request_get($api){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
    }

    protected function api_request_post($api, $data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 5);
        curl_setopt($curl, CURLOPT_POSTFIELDS, is_array($data) ? json_encode($data) : $data);
        $return_str = curl_exec($curl);
        curl_close($curl);
        return $return_str;
    }

}
