# wechat-sdk-php

封装了微信第三方平台接口

## Requirement

php > 5.3

## Installation

## Usage

```php
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

```

其他可参考samples目录
