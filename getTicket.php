<?php

define("APPID","wx38bd235f68377184");
define("APPSECRET","6412760a13e439310695db74fc900ba9");
define("TOKEN","");

requier('./wechat.inc.php');
$wechat = new WeChat(APPID,APPSECRET,TOKEN);
echo $wechat->_getTicket(604800,"temp",1);//临时二维码，有效期7天，场景id是1
//echo $wechat->_getTicket(604800,"forever",2);//永久二维码，场景id是2



