<?php
namespace ezwechat\request;

require_once 'BaseApi.php';

class event extends BaseApi{

    public function __construct(){
        parent::__construct();
    }

    public function parseMsgXml($xml){
        $jsonObj = $this->xml_to_json($xml);
	return $jsonObj;
    }

    public function replayText($toUser, $fromUser, $content){
        $createTime = time();
	$nonce = rand(100000, 999999);
        $xml = sprintf( '<xml><ToUserName><![CDATA[%s]]></ToUserName><FromUserName><![CDATA[%s]]></FromUserName><CreateTime>%d</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[%s]]></Content></xml>', $toUser, $fromUser, $createTime, $content);
	return $xml;
        #return $this->encryptMsg($xml, $createTime, $nonce );
    }
}
