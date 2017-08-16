<?php
return array(
    //数据库配置信息
   'DB_TYPE' => 'mysql', //数据库类型
   'DB_HOST' => '127.0.0.1', // 服务器地址
   'DB_NAME' => 'repairms', // 数据库名
   'DB_USER' => 'root', // 用户名
   'DB_PWD' => '123456', // 密码 
   'DB_PORT' => 3306, // 端口 
   'DB_PREFIX' => 'rm_', // 数据库表前缀 
   'DB_CHARSET'=> 'utf8', // 字符集 
   'DB_DEBUG' => TRUE, // 数据库调试模式 开启后可以记录SQL日志数据库的类型由DB_TYPE参数设置。 
   //表单过滤配置
    'DEFAULT_FILTER'        =>  'trim,htmlspecialchars', // 默认参数过滤方法 用于I函数...
);