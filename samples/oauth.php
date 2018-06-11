<?php
require_once dirname(__DIR__). '/src/request/component.php';

/**
 * 接收微信定时推送的ticket
 */
$msg_sign  = $_GET['msg_sign'];
$timeStamp = $_GET['timeStamp'];
$nonce     = $_GET['nonce'];
$from_xml  = file_get_contents('php://input');

$wechatClient = new \ezwechat\request\component;
$ticket = $wechatClient->parseComponentVerifyTicket($msg_sign, $timeStamp, $nonce, $from_xml);


/**
 * 获取公众号授权链接
 */
if( false !== strpos($_SERVER['HTTP_USER_AGENT'],'MicroMessenger') ){
    $location = $wechatClient->getComponentBindLink();
}else{
    $location = $wechatClient->getComponentLoginpageLink();
}

/**
 * 公众号授权成功之后的回调
 */
$auth_code = $_GET['auth_code'];
$tokenInfo = $wechatClient->getAccessToken($auth_code);
#print_r($tokenInfo);
$wechatClient->getAuthorizerInfo($tokenInfo->authorizer_appid);

