<?php
require_once dirname(__DIR__). '/src/request/component.php';

$appid = '';
$refreshToken = '';

try{
    $wechatClient = new \ezwechat\request\component;
    $refreshToken = $wechatClient->refreshAccessToken( $appid, $refreshToken );
    if(!empty($refreshToken)){
        print_r($refreshToken);
    }
}catch(Exception $e){
    print_r($e);

}

