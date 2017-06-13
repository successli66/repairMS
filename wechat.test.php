<?php

/**
 * 用于测试能否连接到微信，仅第一次配置时使用。
 */
define('TOKEN', 'token');
include_once './wechat.inc.php';
$wechat = new WeChat();
$wechat->valid();

