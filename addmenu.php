<?php

define("APPID","wx38bd235f68377184");
define("APPSECRET","6412760a13e439310695db74fc900ba9");
define("TOKEN","php39");

header('content-type:text/html;charset=utf-8');
require './wechat.inc.php';
$wechat = new $WeChat(APPID,APPSECRET,TOKEN);
$menu = '{
     "button":[
     {	
          "type":"click",
          "name":"今日歌曲",
          "key":"V1001_TODAY_MUSIC"
      },
      {
           "name":"菜单",
           "sub_button":[
           {	
               "type":"view",
               "name":"搜索",
               "url":"http://www.baidu.com/"
            },
            {
                 "type":"miniprogram",
                 "name":"wxa",
                 "url":"http://mp.weixin.qq.com",
                 "appid":"wx286b93c14bbf93aa",
                 "pagepath":"pages/lunar/index"
             },
            {
               "type":"click",
               "name":"赞一下我们",
               "key":"V1001_GOOD"
            }]
       }]
 }';
$wechat->_createmMenu($menu);//创建菜单
