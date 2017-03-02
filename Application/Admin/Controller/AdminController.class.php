<?php

namespace Admin\Controller;

class AdminController extends BaseController {

    public function sysInfo() {
        $info = array(
            //服务器信息
            '服务器信息' => array(
                '操作系统' => php_uname(), //获取系统类型及版本号
                '服务器域名' => $_SERVER["SERVER_NAME"],
                'IP地址' => gethostbyname($_SERVER["SERVER_NAME"]),
                '服务器时间' => date("Y年n月j日 H:i:s"),
                '剩余磁盘空间' => round((disk_free_space(".") / (1024 * 1024)), 2) . 'M',
            ),
            //运行环境信息
            '运行环境信息' => array(
                '运行环境' => $_SERVER["SERVER_SOFTWARE"],
                'PHP版本' => PHP_VERSION,
                'ThinkPHP版本' => THINK_VERSION,
                'WEB服务端口' => $_SERVER["SERVER_PORT"],
                '上传附件限制' => ini_get('upload_max_filesize'),
                '执行时间限制' => ini_get('max_execution_time') . '秒'
            ),
            //数据库信息
            '数据库信息' => array(
                '数据库类型' => 'MySQL',
                '数据库版本' => $this->get_mysql_version()
            ),
            //本机信息
            '本机信息' => array(
                '本机IP地址' => $_SERVER["REMOTE_ADDR"]
            ),
        );
        $this->assign("info", $info);
        $this->display();
    }

    //获得数据库版本
    private function get_mysql_version() {
        $model = M();
        $version = $model->query("select version() as ver");
        return $version[0]['ver'];
    }

}
