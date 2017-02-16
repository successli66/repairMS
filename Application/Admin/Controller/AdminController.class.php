<?php

namespace Admin\Controller;

use Think\Controller;

class AdminController extends Controller {

    public function sysInfo() {
        $info = array(
            //数据库信息
            '操作系统' => PHP_OS,
            '服务器域名' => $_SERVER["SERVER_NAME"],
            'IP' => gethostbyname($_SERVER["SERVER_NAME"]),
            '用户的IP地址' => $_SERVER["REMOTE_ADDR"],
            //服务器信息
            //运行环境信息
            '运行环境' => $_SERVER["SERVER_SOFTWARE"],
            'WEB服务端口' => $_SERVER["SERVER_PORT"],
            '网站文档目录' => $_SERVER["DOCUMENT_ROOT"],
            '通信协议' => $_SERVER["SERVER_PROTOCOL"],
            'PHP运行方式' => php_sapi_name(),
            'PHP版本' => PHP_VERSION,
            //信息
            'ThinkPHP版本' => THINK_VERSION,
            '上传附件限制' => ini_get('upload_max_filesize'),
            '执行时间限制' => ini_get('max_execution_time') . '秒',
            '服务器时间' => date("Y年n月j日 H:i:s"),
            '北京时间' => gmdate("Y年n月j日 H:i:s", time() + 8 * 3600),
            '剩余空间' => round((disk_free_space(".") / (1024 * 1024)), 2) . 'M',
            'mysql_version' => "...",
            'mysql_size' => "...",
            
            
            'os' => $_SERVER["SERVER_SOFTWARE"], //获取服务器标识的字串
            'version' => PHP_VERSION, //获取PHP服务器版本
            'time' => date("Y-m-d H:i:s", time()), //获取服务器时间
            'pc' => $_SERVER['SERVER_NAME'], //当前主机名
            'osname' => php_uname(), //获取系统类型及版本号
            'language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'], //获取服务器语言
            'port' => $_SERVER['SERVER_PORT'], //获取服务器Web端口
            'max_upload' => ini_get("file_uploads") ? ini_get("upload_max_filesize") : "Disabled", //最大上传
            'max_ex_time' => ini_get("max_execution_time")."秒", //脚本最大执行时间
            //'mysql_version' => $this->_mysql_version(),
            //'mysql_size' => $this->_mysql_db_size(),
        );
        var_dump($info);
        $conn = mysql_connect("127.0.0.1", "root", "123456");
        mysql_select_db("数据库名称", "repairMS");
        $result = mysql_query("select version()");
        while ($row = mysql_fetch_array($result)) {
            //print_r($row);
            echo '数据库版本是:' . $row['version()'];
        }
        mysql_close($conn);

        $this->display();
    }

}
