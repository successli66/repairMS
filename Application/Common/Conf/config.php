<?php

return array(
    //常量配置
    'PUBLIC_URL' => '/Public/',
    'COMMON_URL' => '/Common/',
    
    //开启显示追踪信息
    'SHOW_PAGE_TRACE' => true,
    
    //设置请求默认分组
    'DEFAULT_MODULE' => 'Admin',
    'MODULE_ALLOW_LIST' =>array('Home','Admin'),
    
    //数据库配置信息
    'DB_TYPE' => 'mysql', //数据库类型
    'DB_HOST' => '127.0.0.1', // 服务器地址
    'DB_NAME' => 'repairMS', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => '123456', // 密码 
    'DB_PORT' => 3306, // 端口 
    'DB_PREFIX' => 'rm', // 数据库表前缀 
    'DB_CHARSET' => 'utf8', // 字符集 
    'DB_DEBUG' => TRUE, // 数据库调试模式 开启后可以记录SQL日志数据库的类型由DB_TYPE参数设置。
);
